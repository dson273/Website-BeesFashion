<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Order_detail;
use App\Models\Product_vote;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Models\Product_variant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    public function index(string $sku)
    {
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute',
            'categories',
            'product_files',
            'product_variants.product_votes.user',
            'product_variants.order_details.order.status_orders.status'
        ])->where('SKU', $sku)->first();

        //View tăng lên 1
        if ($product) {
            $product->increment('view');
            // Gán giá và phần trăm giảm giá
            $product->priceRange = $product->getPriceRange();
            $product->regularPrice = $product->getRegularPrice();
            $product->discountPercent = $product->getDiscountPercent();
        }

        // Mảng chứa các biến thể với các attribute_value_id liên quan
        $array_variants = $product->product_variants->map(function ($variant) {
            return [
                'variant_id' => $variant->id,
                'regular_price' => $variant->regular_price,
                'sale_price' => $variant->sale_price,
                'stock' => $variant->stock,
                'is_active' => $variant->is_active,
                'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
            ];
        })->toArray();
        // dd($array_variants);

        // Lấy tất cả các attribute_value_id và attribute_id duy nhất
        $attribute_value_ids = $product->product_variants
            ->pluck('variant_attribute_values.*.attribute_value_id')
            ->flatten()
            ->unique()
            ->toArray();

        $attribute_ids = Attribute_value::whereIn('id', $attribute_value_ids)
            ->pluck('attribute_id')
            ->unique()
            ->sort()
            ->toArray();

        // Xây dựng mảng thuộc tính đã lọc
        $array_attributes = Attribute::with([
            'attribute_values' => function ($query) use ($attribute_value_ids) {
                $query->whereIn('id', $attribute_value_ids);
            },
            'attribute_type' // Lấy thông tin loại thuộc tính
        ])->whereIn('id', $attribute_ids)->get()->mapWithKeys(function ($attribute) {
            return [
                $attribute->id => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'type' => $attribute->attribute_type ? $attribute->attribute_type->type_name : null, // Lấy tên loại thuộc tính
                    'attribute_values' => $attribute->attribute_values->sortBy(function ($value) {
                        // Sắp xếp theo thứ tự "S", "M", "L", "XL", nếu giá trị khác số
                        $sizes = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
                        return $sizes[$value->name] ?? $value->name; // Sắp xếp theo thứ tự định trước hoặc theo tên
                    })->values()->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'name' => $value->name,
                            'value' => $value->value
                        ];
                    })->toArray()
                ]
            ];
        })->toArray();

        // Tính tổng số lượng hàng tồn kho của sản phẩm
        $total_stock = Product_variant::where('product_id', $product->id)->sum('stock');

        // Lấy danh sách sản phẩm liên quan qua danh mục
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('category_id', $product->categories->pluck('id'))
                ->where('categories.fixed', 1);
        })->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        $relatedProducts = $relatedProducts->map(function ($relatedProduct) {

            $relatedProduct->priceRange = $relatedProduct->getPriceRange();
            $activeImage = $relatedProduct->product_files->where('is_default', 1)->first();
            $inactiveImage = $relatedProduct->product_files->where('is_default', 0)->first();
            $relatedProduct->active_image = $activeImage ? $activeImage->file_name : null;
            $relatedProduct->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;

            $rating = $this->calculateProductRating($relatedProduct);
            $relatedProduct->rating = $rating;
            return $relatedProduct;
        });

        //Sản phẩm bán chạy
        $firstCategory = Category::where('fixed', 0)->first();
        $bestProducts = Product::whereHas('categories', function ($query) use ($firstCategory) {
            $query->where('categories.id', $firstCategory->id);
        })
            ->with(['product_files', 'product_variants', 'product_variants.product_votes.user'])
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get()
            ->map(function ($bestProduct) {
                $bestProduct->priceRange = $bestProduct->getPriceRange();
                $activeImage = $bestProduct->product_files->where('is_default', 1)->first();
                $inactiveImage = $bestProduct->product_files->where('is_default', 0)->first();
                $bestProduct->active_image = $activeImage ? $activeImage->file_name : null;
                $bestProduct->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;

                $rating = $this->calculateProductRating($bestProduct);
                $bestProduct->rating = $rating;
                return $bestProduct;
            });
        //Đánh giá sản phẩm
        $reviewData = $this->getProductReviewData($product);
        // dd($reviewData);

        return view('user.product-detail', compact('product', 'array_attributes', 'array_variants', 'total_stock', 'relatedProducts', 'reviewData', 'bestProducts'));
    }

    public function updateInformationProduct(Request $request)
    {
        $array_attribute_value_ids = $request->input('attribute_value_ids');
        $product_id = $request->input('product_id');

        // Tìm product_variant phù hợp với attribute_value_ids
        $productFocusQuery = DB::table('product_variants as pv')
            ->where('pv.product_id', $product_id)
            ->whereIn('pv.id', function ($query) use ($array_attribute_value_ids) {
                $query->select('product_variant_id')
                    ->from('product_variant_attribute_values')
                    ->whereIn('attribute_value_id', $array_attribute_value_ids)
                    ->groupBy('product_variant_id')
                    ->havingRaw('COUNT(attribute_value_id) = ?', [count($array_attribute_value_ids)]);
            })->first();

        if ($productFocusQuery) {
            return response()->json([
                'status' => 'success',
                'data' => $productFocusQuery
            ]);
        }
    }
    public function addToCart()
    {
        $variant_id = request()->input('variant_id');
        $quantity = request()->input('quantity');
        if (!auth()->check()) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.'
            ]);
        }
        // Lấy thông tin biến thể
        $variant = Product_variant::select('stock', 'is_active')
            ->where('id', $variant_id)
            ->first();

        // Kiểm tra biến thể có tồn tại và đang hoạt động
        if (!$variant || $variant->is_active == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm này đã ngưng bán. Vui lòng chọn mẫu khác.'
            ], 400);
        }
        // Kiểm tra nếu biến thể đã có trong giỏ hàng
        $checkCart = Cart::with('product_variant')
            ->where('product_variant_id', $variant_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($checkCart) {
            // Tính toán số lượng mới
            $newQuantity = $checkCart->quantity + $quantity;
            // Đảm bảo không vượt quá tồn kho hoặc giới hạn 20 sản phẩm
            if ($newQuantity > $checkCart->product_variant->stock) {
                $checkCart->quantity = $checkCart->product_variant->stock;
            } elseif ($newQuantity > 20) {
                $checkCart->quantity = 20; //Giới hạn chỉ thêm được 20 vào cart
            } else {
                $checkCart->quantity = $newQuantity;
            }
            $checkCart->updated_at->now();
            $checkCart->save();
        } else {
            if ($variant) {
                Cart::create([
                    'quantity' => $quantity <= min($variant->stock, 20) ? $quantity : min($variant->stock, 20),
                    'product_variant_id' => $variant_id,
                    'user_id' => Auth::user()->id,
                    'created_at' => now()
                ]);
            }
        }
        // Tính tổng số lượng giỏ hàng
        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công.',
            'cartCount' => $cartCount
        ]);
    }

    private function calculateProductRating($product)
    {
        $variantIds = $product->product_variants->pluck('id')->toArray();

        $reviews = Product_vote::whereIn('product_variant_id', $variantIds)
            ->where('is_active', 1)
            ->get();

        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('star'), 1) : 5; // Mặc định 5 sao nếu chưa có đánh giá

        return [
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews
        ];
    }

    private function getProductReviewData($product)
    {
        $variantIds = $product->product_variants->pluck('id')->toArray();

        // Lấy đánh giá
        $reviews = Product_vote::whereIn('product_variant_id', $variantIds)
            ->with(['user', 'product_variant'])
            ->orderBy('created_at', 'desc')
            ->get();
        // Lấy đánh giá active để hiển thị trong comments
        $activeReviews = $reviews->where('is_active', 1);
        // Tính toán thống kê
        $totalReviews = $reviews->count();
        $activeReviewCount = $activeReviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('star'), 1) : 5;

        // Tính phần trăm cho từng số sao
        $starCounts = $reviews->groupBy('star');
        $starPercentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = isset($starCounts[$i]) ? $starCounts[$i]->count() : 0;
            $starPercentages[$i] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }

        // Tính tổng số lượng đã bán
        $totalSold = Order_detail::whereIn('product_variant_id', $variantIds)
            ->whereHas('order.status_orders.status', function ($query) {
                $query->where('name', 'Completed');
            })
            ->sum('quantity');

        // Thêm fake_sales nếu có
        $totalSold += $product->fake_sales ?? 0;

        return [
            'reviews' => $activeReviews,
            'stats' => [
                'average_rating' => $averageRating,
                'total_reviews' => $totalReviews,
                'active_review_count' => $activeReviewCount,
                'star_percentages' => $starPercentages,
                'total_sold' => $totalSold
            ]
        ];
    }
}

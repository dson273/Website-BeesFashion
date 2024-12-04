<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Models\Product_vote;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //Trang chủ
    public function index()
    {
        $sliders  = Banner::where('is_active', 1)
            ->with('banner_images') // Lấy các hình ảnh liên quanp
            ->get();
        $brands  = Brand::where('is_active', 1)
            ->get();
        $vouchers = Voucher::where('is_active', 1)
            ->where('end_date', '>=', Carbon::now())
            ->limit(8)
            ->get();
        //Sản phẩm nhiều lượt xem
        $topProducts = Product::with(['product_files', 'product_variants.product_votes.user'])
            ->where('is_active', 1)
            ->orderBy('view', 'DESC')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                $activeImage = $product->product_files->where('is_default', 1)->first();
                $inactiveImage = $product->product_files->where('is_default', 0)->first();
                $product->active_image = $activeImage ? $activeImage->file_name : null;
                $product->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;
                $product->priceRange =  $product->getPriceRange();
                $product->priceRange =  $product->getPriceRange();
                $rating = $this->getProductReviewData($product);
                $product->rating = $rating;
                return $product;
            });
        //Sản phẩm mới nhất
        $newProducts = Product::with(['product_files', 'product_variants.product_votes.user'])
            ->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                $activeImage = $product->product_files->where('is_default', 1)->first();
                $inactiveImage = $product->product_files->where('is_default', 0)->first();
                $product->active_image = $activeImage ? $activeImage->file_name : null;
                $product->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;
                $product->priceRange =  $product->getPriceRange();
                $rating = $this->getProductReviewData($product);
                $product->rating = $rating;

                return $product;
            });

        //Sản phẩm bán chạy
        $firstCategory = Category::where('fixed', 0)->first();
        $products = Product::whereHas('categories', function ($query) use ($firstCategory) {
            $query->where('categories.id', $firstCategory->id); // Thêm "categories." để chỉ rõ cột id của bảng categories
        })
            ->with(['product_files', 'product_variants', 'product_variants.product_votes.user'])
            ->limit(8)
            ->get()
            ->map(function ($product) {
                $activeImage = $product->product_files->where('is_default', 1)->first();
                $inactiveImage = $product->product_files->where('is_default', 0)->first();
                $product->active_image = $activeImage ? $activeImage->file_name : null;
                $product->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;
                $product->priceRange = $product->getPriceRange();
                $product->priceRange =  $product->getPriceRange();
                $rating = $this->getProductReviewData($product);
                $product->rating = $rating;
                return $product;
            });


        $firstCategory = Category::where('fixed', 0)
            ->orderBy('created_at', 'desc')  // Sắp xếp theo ngày tạo giảm dần (mới nhất trước)
            ->first();
        $productTrending = Product::whereHas('categories', function ($query) use ($firstCategory) {
            $query->where('categories.id', $firstCategory->id); // Thêm "categories." để chỉ rõ cột id của bảng categories
        })
            ->with(['product_files', 'product_variants', 'product_variants.product_votes.user'])
            ->limit(8)
            ->get()
            ->map(function ($product) {
                // Xử lý hình ảnh sản phẩm
                $activeImage = $product->product_files->where('is_default', 1)->first();
                $inactiveImage = $product->product_files->where('is_default', 0)->first();
                $product->active_image = $activeImage ? $activeImage->file_name : null;
                $product->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;

                // Lấy giá sản phẩm
                $product->priceRange = $product->getPriceRange();

                // Lấy đánh giá sản phẩm
                $rating = $this->getProductReviewData($product);
                $product->rating = $rating;

                return $product;
            });
        return view('user.index', compact('sliders', 'brands', 'vouchers', 'topProducts', 'newProducts', 'products', 'productTrending'));
    }

    public function getProductDetails($productId)
    {
        // Lấy sản phẩm từ database
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute',
            'product_files'
        ])->findOrFail($productId);

        // Chuẩn bị dữ liệu cần trả về
        $productDetails = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->SKU,
            'description' => $product->description,
            'imageUrl' => asset('uploads/products/images/' . $product->product_files->first()->file_name), // Ảnh sản phẩm chính
            'relatedImages' => $product->product_files->map(function ($file) {
                return asset('uploads/products/images/' . $file->file_name);
            })->toArray(),
            'array_variants' => $product->product_variants->map(function ($variant) {
                return [
                    'variant_id' => $variant->id,
                    'regular_price' => $variant->regular_price,
                    'sale_price' => $variant->sale_price,
                    'stock' => $variant->stock,
                    'is_active' => $variant->is_active,
                    'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
                ];
            })->toArray(),

            $attribute_value_ids = $product->product_variants
                ->pluck('variant_attribute_values.*.attribute_value_id')
                ->flatten()
                ->unique()
                ->toArray(),

            $attribute_ids = Attribute_value::whereIn('id', $attribute_value_ids)
                ->pluck('attribute_id')
                ->unique()
                ->sort()
                ->toArray(),

            'array_attributes' => Attribute::with([
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
            })->toArray(),

        ];

        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json($productDetails);
    }

    public function addToCart(Request $request)
    {
        // Xác định các dữ liệu cần thiết từ request
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('quantity', 1); // Mặc định số lượng là 1 nếu không có

        // Kiểm tra nếu không có variant_id
        if (!$variant_id) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
            ], 400); // Trả về mã lỗi 400
        }

        // Kiểm tra giỏ hàng của người dùng hiện tại
        $cartItem = Cart::where('product_variant_id', $variant_id)  // Sửa ở đây, không cần `$variant_id->id`
            ->where('user_id', auth()->id())
            ->first();

        if ($cartItem) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'product_variant_id' => $variant_id,
                'user_id' => auth()->id(),
                'quantity' => $quantity,
            ]);
        }
        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
            'cartCount' => $cartCount
        ]);
    }

    private function getProductReviewData($product)
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
    //Trang thanh toán
    public function checkout()
    {
        return view('user.check-out');
    }
}

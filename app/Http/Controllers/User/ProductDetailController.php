<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Models\Product_variant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_variant_attribute_value;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute',
            'categories',
            'product_files'
        ])->find($id);

        //View tăng lên 1
        if ($product) {
            $product->increment('view');
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
        $total_stock = Product_variant::where('product_id', $id)->sum('stock');

        // Lấy giá của biến thể
        if ($product) {
            $variants = $product->product_variants;
            // Lọc các biến thể có `sale_price` không null
            $variantsWithSalePrice = $variants->filter(function ($variant) {
                return $variant->sale_price !== null;
            });
            // Lọc các biến thể chỉ có `regular_price`
            $variantsWithoutSalePrice = $variants->filter(function ($variant) {
                return $variant->sale_price === null;
            });
            // Tìm giá trị thấp nhất và cao nhất
            if ($variantsWithSalePrice->isNotEmpty()) {
                $minPrice = $variantsWithSalePrice->min('sale_price');
                $maxPrice = $variantsWithoutSalePrice->isNotEmpty()
                    ? $variantsWithoutSalePrice->max('regular_price')
                    : $variantsWithSalePrice->max('sale_price');
            } else {
                $minPrice = $variantsWithoutSalePrice->min('regular_price');
                $maxPrice = $variantsWithoutSalePrice->max('regular_price');
            }
            // Gán giá trị khoảng giá vào thuộc tính mới
            $product->priceRange = $minPrice === $maxPrice
                ? number_format($minPrice, 0, ',', '.') . 'đ'
                : number_format($minPrice, 0, ',', '.') . 'đ' . ' - ' . number_format($maxPrice, 0, ',', '.') . 'đ';
            $product->regularPrice = $variants->max('regular_price');
            // Tính phần trăm giảm giá
            $maxRegularPrice = $variants->max('regular_price');
            $minSalePrice = $variantsWithSalePrice->min('sale_price');

            if ($maxRegularPrice && $minSalePrice) {
                $discountPercent = number_format((100 - ($minSalePrice / $maxRegularPrice * 100)), 1, '.', '');
                $product->discountPercent = '-' . $discountPercent . '%';
            } else {
                $product->discountPercent = 'Hot!';
            }
        }

        // Lấy danh sách sản phẩm liên quan qua danh mục
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('category_id', $product->categories->pluck('id'));
        })->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        $relatedProducts = $relatedProducts->map(function ($relatedProduct) {
            $variants = $relatedProduct->product_variants;
            $variantsWithSalePrice = $variants->filter(function ($variant) {
                return $variant->sale_price !== null;
            });
            $variantsWithoutSalePrice = $variants->filter(function ($variant) {
                return $variant->sale_price === null;
            });
            if ($variantsWithSalePrice->isNotEmpty()) {
                $minPrice = $variantsWithSalePrice->min('sale_price');
                $maxPrice = $variantsWithoutSalePrice->isNotEmpty()
                    ? $variantsWithoutSalePrice->max('regular_price')
                    : $variantsWithSalePrice->max('sale_price');
            } else {
                $minPrice = $variantsWithoutSalePrice->min('regular_price');
                $maxPrice = $variantsWithoutSalePrice->max('regular_price');
            }
            $relatedProduct->priceRange = $minPrice === $maxPrice
                ? number_format($minPrice, 0, ',', '.') . 'đ'
                : number_format($minPrice, 0, ',', '.') . 'đ' . ' - ' . number_format($maxPrice, 0, ',', '.') . 'đ';

            $activeImage = $relatedProduct->product_files->where('is_default', 1)->first();
            $inactiveImage = $relatedProduct->product_files->where('is_default', 0)->first();
            $relatedProduct->active_image = $activeImage ? $activeImage->file_name : null;
            $relatedProduct->inactive_image = $inactiveImage ? $inactiveImage->file_name : null;
            return $relatedProduct;
        });

        return view('user.product-detail', compact('product', 'array_attributes', 'array_variants', 'total_stock', 'relatedProducts'));
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
    public function addToCart(string $variant_id, string $quantity)
    {
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
            // Đảm bảo không vượt quá tồn kho hoặc giới hạn 10 sản phẩm
            if ($newQuantity > $checkCart->product_variant->stock) {
                $checkCart->quantity = $checkCart->product_variant->stock;
            } elseif ($newQuantity > 10) {
                $checkCart->quantity = 10; //Giới hạn chỉ thêm được 10 vào cart
            } else {
                $checkCart->quantity = $newQuantity;
            }
            $checkCart->updated_at->now();
            $checkCart->save();
        } else {
            if ($variant) {
                Cart::create([
                    'quantity' => $quantity <= min($variant->stock, 10) ? $quantity : min($variant->stock, 10),
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Models\Product_variant;
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
                'attribute_values' => $variant->variant_attribute_values->pluck('attribute_value_id')->toArray()
            ];
        })->toArray();

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
            $minPrice = $product->product_variants->min('sale_price');
            $maxPrice = $product->product_variants->max('sale_price');

            // Gán giá trị khoảng giá vào thuộc tính mới
            $product->priceRange = $minPrice === $maxPrice
                ? number_format($minPrice, 0, ',', '.') . 'đ'
                : number_format($minPrice, 0, ',', '.') . 'đ' . ' - ' . number_format($maxPrice, 0, ',', '.') . 'đ';
        }
        // Lấy danh sách sản phẩm liên quan qua danh mục
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('category_id', $product->categories->pluck('id'));
        })->where('id', '!=', $product->id)
          ->take(8)
          ->get();

        $relatedProducts = $relatedProducts->map(function ($relatedProduct) {
            $minPrice = $relatedProduct->product_variants->min('sale_price');
            $maxPrice = $relatedProduct->product_variants->max('sale_price');
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

        $productFocusQuery = Product_variant_attribute_value::query()
            ->join('product_variants as pv', 'product_variant_attribute_values.product_variant_id', '=', 'pv.id')
            ->select('pv.*')
            ->where('pv.product_id', $product_id)
            ->whereIn('product_variant_attribute_values.attribute_value_id', $array_attribute_value_ids)
            ->groupBy('pv.id')
            ->havingRaw('COUNT(DISTINCT product_variant_attribute_values.attribute_value_id) = ?', [count($array_attribute_value_ids)])
            ->get();

        if ($productFocusQuery->isNotEmpty()) {
            $productDetailUpdate = $productFocusQuery->first();
            $response = [
                'status' => 'success',
                'data' => $productDetailUpdate
            ];
            return response()->json($response);
        }
    }
    public function addToCart(string $variant_id, string $quantity)
    {
        $checkCart = Cart::with('product_variant')->where('product_variant_id', $variant_id)->where('user_id', Auth::user()->id)->first();
        if ($checkCart) {
            if ($checkCart->product_variant->stock < $checkCart->quantity + $quantity) {
                $checkCart->quantity = $checkCart->product_variant->stock;
            } else if ($checkCart->quantity + $quantity > 10) {
                $checkCart->quantity = 10;
            } else {
                $checkCart->quantity = $checkCart->quantity + $quantity;
            }
            $checkCart->updated_at->now();
            $checkCart->save();
        } else {
            $variant = Product_variant::select('stock')->where('id', $variant_id)->first();
            if ($variant) {
                Cart::create([
                    'quantity' => $quantity <= $variant->stock ? $quantity : $variant->stock,
                    'product_variant_id' => $variant_id,
                    'user_id' => Auth::user()->id,
                    'created_at' => now()
                ]);
            }
        }
        return redirect()->back()->with('statusSuccess', 'Thêm sản phẩm vào giỏ hàng thành công.');
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

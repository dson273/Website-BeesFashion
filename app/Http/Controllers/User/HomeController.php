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
use App\Models\Product_variant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $vouchers = Voucher::where('is_active', 1)
            ->where('end_date', '>=', Carbon::now())
            ->limit(8)
            ->get();
        $topProducts = Product::with(['product_files'])
            ->where('is_active', 1)
            ->orderBy('view', 'DESC')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                $product->priceRange =  $product->getPriceRangeAttribute();
                return $product;
            });
        $newProducts = Product::with(['product_files'])
            ->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                $product->priceRange =  $product->getPriceRangeAttribute();
                return $product;
            });
        $products = Product::whereHas('categories', function ($query) {
            $query->where('fixed', 0);
        })
            ->with(['product_files', 'product_variants'])
            ->limit(8)
            ->get()
            ->map(function ($product) {
                $product->priceRange = $product->getPriceRangeAttribute();
                return $product;
            });

        return view('user.index', compact('sliders', 'vouchers', 'topProducts', 'newProducts', 'products'));
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
            'price' => $product->getPriceRangeAttribute(),  // Giá sản phẩm (ví dụ: dải giá)
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


    //Trang thanh toán
    public function checkout()
    {
        return view('user.check-out');
    }
}

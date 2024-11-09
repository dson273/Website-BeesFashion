<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\Attribute_type;
use App\Models\Attribute_value;
use App\Models\Product_variant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_variant_attribute_value;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //Trang chủ
    public function index()
    {

        $sliders  = Banner::where('is_active', 1)
            ->with('banner_images') // Load các hình ảnh liên quan
            ->get();

        $topProducts = Product::with(['product_files', 'product_variants.import_histories'])
            ->orderBy('view', 'DESC')
            ->take(4)
            ->get()
            ->map(function ($product) {
                $minPrice = $product->product_variants->min('sale_price');
                $maxPrice = $product->product_variants->max('sale_price');
                $product->priceRange = $minPrice === $maxPrice ? $minPrice : "$minPrice - $maxPrice";
                return $product;
            });
        $newProducts = Product::with(['product_files', 'product_variants.import_histories'])
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get()
            ->map(function ($product) {
                $minPrice = $product->product_variants->min('sale_price');
                $maxPrice = $product->product_variants->max('sale_price');
                $product->priceRange = $minPrice === $maxPrice ? $minPrice : "$minPrice - $maxPrice";
                return $product;
            });
        $products = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->where('categories.fixed', 0)
            ->with(['product_files', 'product_variants.import_histories'])
            ->select('products.*') // Chọn các trường từ bảng products
            ->get()
            ->map(function ($product) {
                $minPrice = $product->product_variants->min('sale_price');
                $maxPrice = $product->product_variants->max('sale_price');
                $product->priceRange = $minPrice === $maxPrice ? $minPrice : "$minPrice - $maxPrice";
                return $product;
            });

        return view('user.index', compact('sliders', 'topProducts', 'newProducts', 'products'));
    }

    //Trang dashboard người dùng
    public function dashboard()
    {
        return view('user.dashboard');
    }

    //Trang thanh toán
    public function checkout()
    {
        return view('user.check-out');
    }

    //Trang chi tiết sản phẩm
    public function product_detail(string $id)
    {
        $product = Product::with([
            'product_variants.variant_attribute_values.attribute_value.attribute'
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

        // Lấy hình ảnh của biến thể sản phẩm (duy nhất)
        $productImages = Product_variant::select('image')
            ->where('product_id', $id)
            ->groupBy('image')
            ->get();

        // Tính tổng số lượng hàng tồn kho của sản phẩm
        $total_stock = Product_variant::where('product_id', $id)->sum('stock');

        // Lấy giá của biến thể
        if ($product) {
            $minPrice = $product->product_variants->min('sale_price');
            $maxPrice = $product->product_variants->max('sale_price');

            // Gán giá trị khoảng giá vào thuộc tính mới
            $product->priceRange = $minPrice === $maxPrice
                ? number_format($minPrice, 0, ',', '.') . 'đ'
                : number_format($minPrice, 0, ',', '.'). 'đ' . ' - ' . number_format($maxPrice, 0, ',', '.') . 'đ';
        }

        return view('user.product-detail', compact('product', 'array_attributes', 'array_variants', 'productImages', 'total_stock'));
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

    //Trang giỏ hàng
    public function cart()
    {
        $carts = Auth::user()->carts;
        $cart_list = [];
        foreach ($carts as $itemCart) {
            $array_item_cart = [];
            $array_item_cart['quantity'] = $itemCart->quantity;
            $variants = $itemCart->product_variant;

            $array_item_cart['product_name'] = Product_variant::select('p.name')
                ->rightJoin('products as p', 'product_variants.product_id', '=', 'p.id')
                ->first()->name;

            $array_item_cart['image'] = Product_variant::where('id', $variants->id)->value('image');
            $array_item_cart['regular_price'] = $variants->regular_price;
            $array_item_cart['sale_price'] = $variants->sale_price;
            $array_item_cart['stock'] = $variants->stock;
            $array_item_cart['product_id'] = $variants->product_id;
            $array_item_cart['variant_id'] = $variants->id;
            $array_item_cart['id_cart'] = $itemCart->id;

            // Lấy thông tin thuộc tính và giá trị
            $array_item_attribute_values = [];
            $productAttributeValueDetails = Product_variant_attribute_value::where('product_variant_id', $variants->id)->get();

            foreach ($productAttributeValueDetails as $itemProductAttributeValueDetail) {
                $attributeValue = $itemProductAttributeValueDetail->attribute_value;
                $attribute = $attributeValue->attribute;

                $array_item_attribute_values[] = [
                    'attribute_name' => $attribute->name,
                    'value_name' => $attributeValue->name,
                    'value_code' => $attributeValue->value
                ];
            }

            $array_item_cart['attribute_values'] = $array_item_attribute_values;
            $cart_list[] = $array_item_cart;
        }
        // dd($cart_list);
        $total_payment = 0;
        $total_discount = 0;
        foreach ($cart_list as $item_cart) {
            if ($item_cart['sale_price'] != null) {
                $discount = $item_cart['regular_price'] - $item_cart['sale_price'];
                $total_discount += $discount * $item_cart['quantity'];
                $total_payment += $item_cart['sale_price'] * $item_cart['quantity'];
            } else {
                $total_payment += $item_cart['regular_price'] * $item_cart['quantity'];
            }
        }
        return view('user.cart', compact('cart_list', 'total_payment', 'total_discount'));
    }
}

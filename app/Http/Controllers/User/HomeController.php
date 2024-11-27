<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
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
            ->with('banner_images') // Lấy các hình ảnh liên quan
            ->get();

        $topProducts = Product::with(['product_files'])
            ->where('is_active', 1)
            ->orderBy('view', 'DESC')
            ->limit(4)
            ->get()
            ->map(function ($product) {
                $product->priceRange =  $product->priceProduct();
                return $product;
            });
        $newProducts = Product::with(['product_files'])
            ->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->get()
            ->map(function ($product) {
                $product->priceRange =  $product->priceProduct();
                return $product;
            });
        $products = Product::whereHas('categories', function ($query) {
                $query->where('fixed', 0);
            })
            ->with(['product_files', 'product_variants'])
            ->limit(4)
            ->get()
            ->map(function ($product) {
                $product->priceRange = $product->priceProduct();
                return $product;
            });

        return view('user.index', compact('sliders', 'topProducts', 'newProducts', 'products'));
    }
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id'); // ID của sản phẩm hiện tại
        $sizeId = $request->input('size_id');       // ID của kích cỡ được chọn
        $colorId = $request->input('color_id');     // ID của màu sắc được chọn
    
        // Tìm product_variant dựa trên product_id, size_id, và color_id
        $productVariant = Product_variant::where('product_id', $productId) // Chỉ tìm trong sản phẩm hiện tại
            ->whereHas('variant_attribute_values', function ($query) use ($sizeId) {
                $query->where('attribute_value_id', $sizeId); // Lọc theo size
            })
            ->whereHas('variant_attribute_values', function ($query) use ($colorId) {
                $query->where('attribute_value_id', $colorId); // Lọc theo color
            })
            ->first();
    
        // Nếu không tìm thấy product_variant
        if (!$productVariant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy biến thể sản phẩm phù hợp.',
            ]);
        }
    
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
        $cartItem = Cart::where('product_variant_id', $productVariant->id)
            ->where('user_id', auth()->id()) // Giỏ hàng của người dùng hiện tại
            ->first();
    
        if ($cartItem) {
            // Nếu sản phẩm đã tồn tại, tăng số lượng
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới
            Cart::create([
                'product_variant_id' => $productVariant->id,
                'user_id' => auth()->id(),
                'quantity' => 1, // Mặc định là 1
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
        ]);
    }
    
    
    //Trang thanh toán
    public function checkout()
    {
        return view('user.check-out');
    }
}

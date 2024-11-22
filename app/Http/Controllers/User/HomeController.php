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
            ->get()
            ->map(function ($product) {
                $product->priceRange =  $product->priceProduct();
                return $product;
            });
        $newProducts = Product::with(['product_files'])
            ->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($product) {
                $product->priceRange =  $product->priceProduct();
                return $product;
            });
        $products = Product::whereHas('categories', function ($query) {
                $query->where('fixed', 0);
            })
            ->with(['product_files', 'product_variants'])
            ->get()
            ->map(function ($product) {
                $product->priceRange = $product->priceProduct();
                return $product;
            });

        return view('user.index', compact('sliders', 'topProducts', 'newProducts', 'products'));
    }

    //Trang thanh toán
    public function checkout()
    {
        return view('user.check-out');
    }
}

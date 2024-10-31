<?php

namespace App\Http\Controllers\User;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    //Trang chi tiết sản phẩm
    public function product_detail(Product $product){
        return view('user.product-detail', compact('product'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $sliders  = Banner::where('is_active', 1)
            ->with('banner_images') // Load các hình ảnh liên quan
            ->get();

        $topProducts = Product::with(['product_files', 'product_variants.import_histories'])
            ->orderBy('view', 'DESC')
            ->take(4)
            ->get();
        $newProducts = Product::with(['product_files', 'product_variants.import_histories'])
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();
        $products = Product::join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->where('categories.fixed', 0)
            ->with(['product_files', 'product_variants.import_histories'])
            ->select('products.*') // Chọn các trường từ bảng products
            ->get();

        return view('user.index', compact('sliders', 'topProducts', 'newProducts', 'products'));
    }
    

    public function dashboard()
    {
        return view('user.dashboard');
    }
}

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

     public function index(){
        $sliders  = Banner::where('is_active', 1)
        ->with('banner_images') // Load các hình ảnh liên quan
        ->get();
        $topProducts = Product::orderBy('view', 'desc')->limit(4)->get();
        $newProducts = Product::orderBy('created_at', 'desc')->limit(4)->get();
        return view('user.index', compact('sliders','topProducts','newProducts'));
     }

    public function dashboard()
    {
        return view('user.dashboard');
    }


}

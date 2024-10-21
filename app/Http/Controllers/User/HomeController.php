<?php

namespace App\Http\Controllers\User;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(){
        $sliders  = Banner::where('is_active', 1)
        ->with('banner_images') // Load các hình ảnh liên quan
        ->get();
        $category = Category::all();
        return view('user.index', compact('sliders','category'));
     }
    public function dashboard()
    {
        return view('user.dashboard');
    }

    
}

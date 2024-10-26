<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        //View trang đăng ký
        return view('user.auth.register');
    }

    public function register(Request $request){
        //Xử lý logic đăng ký
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string','unique:users', 'max:100'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
        //Tạo user mới
        $user = User::query()->create($data);
        //Login với user vừa tạo
        Auth::login($user);
        // gen lại token cho user vừa đăng nhập
        $request->session()->regenerate();

        //quay lại trang phía trước
        return redirect()->intended('/');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ],
        [
            'username.required' => 'Tên người dùng là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
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

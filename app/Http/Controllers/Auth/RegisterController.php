<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        //View trang đăng ký
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        //Xử lý logic đăng ký
        $data = $request->validate([
            'username' => [
                'required',
                'string',
                'unique:users,username',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/', // Chỉ cho phép chữ cái, số và dấu gạch dưới
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users,email',
                'max:100',
            ],
            'password' => [
                'required',
                'string',
                'min:6', // Yêu cầu tối thiểu 6 ký tự
                'max:50', // Giới hạn tối đa 50 ký tự
                'confirmed', // Yêu cầu nhập lại mật khẩu khớp
                'regex:/^\S+$/',
            ],
        ], [
            'username.required' => 'Tên người dùng không được để trống!',
            'username.string' => 'Tên người dùng phải là chuỗi ký tự!',
            'username.unique' => 'Tên người dùng đã tồn tại!',
            'username.max' => 'Tên người dùng không được vượt quá 50 ký tự!',
            'username.regex' => 'Tên người dùng chỉ được chứa chữ cái, số và dấu gạch dưới!',

            'email.required' => 'Email không được để trống!',
            'email.string' => 'Email phải là chuỗi ký tự!',
            'email.email' => 'Email không đúng định dạng!',
            'email.unique' => 'Email đã tồn tại!',
            'email.max' => 'Email không được vượt quá 100 ký tự!',

            'password.required' => 'Mật khẩu không được để trống!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'password.max' => 'Mật khẩu không được vượt quá 50 ký tự!',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp!',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng!',
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

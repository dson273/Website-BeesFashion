<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User_ban;

class LoginController extends Controller
{
    public function index()
    {
        return view('user.auth.login');
    }
    public function login(Request $request)
    {
        // Kiểm tra xem người dùng nhập username hay email
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = $request->validate([
            'login' => [
                'required',
                'string',
                'max:100',
                'regex:/^\S+$/', // Không cho phép khoảng trắng (cả đầu, giữa và cuối)
                $fieldType === 'email' ? 'email' : 'string',
            ],
            'password' => [
                'required',
                'string',
                'min:6', // Mật khẩu phải có ít nhất 6 ký tự
                'regex:/^\S+$/', // Không cho phép khoảng trắng trong mật khẩu
            ],
        ], [
            'login.required' => 'Vui lòng nhập tên người dùng hoặc email!',
            'login.string' => 'Tên người dùng hoặc email phải là chuỗi ký tự hợp lệ!',
            'login.max' => 'Tên người dùng hoặc email không được vượt quá 100 ký tự!',
            'login.regex' => 'Tên người dùng hoặc email không được chứa khoảng trắng!',
            'login.email' => 'Email không đúng định dạng!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng!',
        ]);

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            // Đăng nhập thành công
            $request->session()->regenerate();

            // Kiểm tra trạng thái tài khoản có bị banned không
            if (Auth::user()->status === 'banned') {
                // Tìm lý do và thời gian ban
                $bannedUser = User_ban::where('user_id', Auth::id())
                    ->where('is_active', 1) // Kiểm tra trạng thái ban
                    ->first();
                $reason = $bannedUser ? 'Lý do: ' . $bannedUser->reason : 'Không có lý do cụ thể.';
                Auth::logout(); // Đăng xuất người dùng
                return redirect()->back()->withErrors([
                    'login' => 'Tài khoản của bạn đã bị khóa! ' . $reason,
                ])->withInput();
            }

            // Kiểm tra vai trò của người dùng
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
                // Điều hướng đến trang quản trị nếu là admin hoặc staff
                return redirect()->intended('/admin');
            } else {
                // Điều hướng đến trang người dùng nếu là member
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'login' => 'Thông tin đăng nhập không chính xác!',
        ])->onlyInput('login');
    }
    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect('/');
    }
}

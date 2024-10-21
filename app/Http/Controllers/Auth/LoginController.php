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
                $fieldType === 'email' ? 'email' : 'string', // Kiểm tra định dạng email nếu nhập email
            ],
            'password' => 'required|min:6',
        ], [
            'login.required' => 'Please enter username or email.',
            'login.email' => 'Email is not in correct format.'
        ]);


        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            // Đăng nhập thành công
            $request->session()->regenerate();

            // // Kiểm tra xem người dùng có bị ban không
            // $bannedUser = User_ban::where('user_id', Auth::id())
            //                       ->where('is_active', 1) // Kiểm tra trạng thái active
            //                       ->first();
            // if ($bannedUser) {
            //     Auth::logout(); // Đăng xuất người dùng
            //     return redirect()->back()->withErrors([
            //         'email' => 'Bạn đã bị khóa! Lý do: ' . $bannedUser->reason,
            //     ])->withInput();
            // }

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
            'login' => 'Login information is incorrect!',
        ])->onlyInput('login');

    }
    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect('/');
    }
}

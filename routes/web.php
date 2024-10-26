<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\user\CollectionController;


Route::get('/',[HomeController::class,'index'])->name('/');
//Đăng ký
Route::get('register', [RegisterController::class, 'index'])->name('register');//Trang đăng ký
Route::post('register', [RegisterController::class, 'register'])->name('register');//Chức năng đăng ký
//Đăng nhập
Route::get('login', [LoginController::class, 'index'])->name('login');//Trang đăng nhập
Route::post('login', [LoginController::class, 'login'])->name('login');//Chức năng đăng nhập


// Route::get('/', action: function () {
//     return view(view: 'user/index');
// });
// Route::get('collection', action: function () {
//     return view(view: 'user/collection');
// });
// Route::get('/',[HomeController::class,'index'])->name('home-shop');

Route::get('forgot-password', [ForgotPasswordController::class, 'ForgotForm'])->name('fotgot-pasword');//Trang quên mật khẩu

Route::post('forgot-processing', [ForgotPasswordController::class, 'resetPassword'])->name('forgot-processing'); // Chức năng lấy lại mật khẩu



// web.php hoặc api.php
Route::get('collection', [CollectionController::class, 'index'])->name('collection');
// Route::get('api/products', [CollectionController::class, 'getProducts']);



Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');//Chức năng đăng xuất
    //Dashboard người dùng
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::put('dashboard/edit-profile',[DashboardController::class,'editProfile'])->name('dashboard.editProfile');// Cập nhật thông tin profile
    Route::post('dashboard/add-address', [DashboardController::class, 'addAddress'])->name('dashboard.addAddress');//Thêm địa chỉ giao hàng
    Route::put('dashboard/edit-address/{id}',[DashboardController::class,'editAddress'])->name('dashboard.editAddress');// Sửa địa chỉ
    Route::delete('dashboard/delete-address/{id}',[DashboardController::class,'deleteAddress'])->name('dashboard.deleteAddress');// Xoá địa chỉ
    // Route::post('dashboard/shipping-addresses/set-default/{id}', [DashboardController::class, 'setDefaultShippingAddress'])->name('dashboard.addresses.set.default');//Set địa chỉ mặc định
});

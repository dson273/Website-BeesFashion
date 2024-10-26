<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('/');

//Đăng ký
Route::get('register', [RegisterController::class, 'index'])->name('register');//Trang đăng ký
Route::post('register', [RegisterController::class, 'register'])->name('register');//Chức năng đăng ký
//Đăng nhập
Route::get('login', [LoginController::class, 'index'])->name('login');//Trang đăng nhập
Route::post('login', [LoginController::class, 'login'])->name('login');//Chức năng đăng nhập

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

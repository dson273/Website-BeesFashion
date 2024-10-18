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

Route::get('/', action: function () {
    return view(view: 'user/index');
});

Route::get('/',[HomeController::class,'index'])->name('home-shop');

Route::middleware('auth')->group(function () {
    //Dashboard người dùng
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    //Thêm địa chỉ
    Route::post('dashboard/address/add', [DashboardController::class, 'addAddress'])->name('dashboard.addAddress');
    // Sửa địa chỉ
    Route::put('dashboard/address/edit/{id}',[DashboardController::class,'editAddress'])->name('dashboard.editAddress');
    // Xoá địa chỉ
    Route::delete('dashboard/address/delete/{id}',[DashboardController::class,'deleteAddress'])->name('dashboard.deleteAddress');
    //Set địa chỉ mặc định
    Route::post('dashboard/shipping-addresses/set-default/{id}', [DashboardController::class, 'setDefaultShippingAddress'])->name('dashboard.addresses.set.default');

});
//đăng ký
Route::get('auth/register', [RegisterController::class, 'index'])->name('register');
// Route::post('auth/register', [RegisterController::class, 'register'])->name('register');
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');

//Đăng nhập
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

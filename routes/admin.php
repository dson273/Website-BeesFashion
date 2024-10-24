<?php

use App\Http\Controllers\Admin\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\admin\AttributeTypeController;
use App\Http\Controllers\admin\AttributeValueController;

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



Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {
    //Route cho chỉ dành cho admin
    Route::middleware(['role:admin'])->group(function () {
        // Các chức năng chỉ admin được phép quản lý
        Route::resource('staffs', StaffController::class); //Quản lý nhân viên
        Route::post('staffs/ban/{id}', [StaffController::class, 'ban'])->name('staffs.ban'); //Ban nhân viên
        Route::post('staffs/unban/{id}', [StaffController::class, 'unban'])->name('staffs.unban'); //Unban nhân viên
        Route::get('staffs/history/{id}', [StaffController::class, 'history'])->name('staffs.history'); //Lịch sử ban/unban
        Route::get('staffs/permission/{user}', [StaffController::class, 'permission'])->name('staffs.permission'); //Quyền nhân viên
        // Cập nhật quyền của nhân viên
        Route::post('staffs/permission/{user}/{managerSetting}/toggle', [StaffController::class, 'togglePermission'])->name('staffs.permissions.toggle');
    });
    
    // Route cho staff (admin cũng có thể truy cập)
    Route::middleware(['role:staff|admin'])->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        // Các chức năng staff có thể quản lý

        //Quản lý danh mục
        Route::middleware(['checkPermission:Quản lý danh mục'])->group(function () {
            Route::resource('categories', CategoryController::class);
        });

        //Quản lý sản phẩm
        Route::middleware(['checkPermission:Quản lý sản phẩm'])->group(function () {
            Route::resource('products', ProductController::class);
            Route::post('products/getAttributes', action: [ProductController::class, 'getAllAttributes'])->name('getAllAttributes');
        });

        //Quản lý thuộc tính
        Route::middleware(['checkPermission:Quản lý thuộc tính'])->group(function () {
            Route::resource('attributes', AttributeController::class);
            //Quản lý loại thuộc tính
            Route::resource('attribute_types', AttributeTypeController::class);
            //Quản lý dữ liệu thuộc tính
            Route::resource('attribute_values', AttributeValueController::class);
        });

        //Quản lý banner
        Route::middleware(['checkPermission:Quản lý banner'])->group(function () {
            Route::resource('banner', BannerController::class);
            Route::get('banner/onactive/{id}', [BannerController::class, 'onActive'])->name('banner.onactive');
            Route::get('banner/offactive/{id}', [BannerController::class, 'offActive'])->name('banner.offactive');
        });

        //Quản lý khách hàng
        Route::middleware(['checkPermission:Quản lý khách hàng'])->group(function () {
            Route::resource('customers', CustomerController::class);
        });
    });
});

// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

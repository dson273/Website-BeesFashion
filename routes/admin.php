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
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ManagerSettingController;


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



Route::prefix('admin')->as('admin.')->group(function () {
    //Route cho chỉ dành cho admin
    // Route::middleware(['role:admin'])->group(function () {
        // Các chức năng chỉ admin được phép quản lý
        //Quản lý nhân viên
        Route::resource('staffs', StaffController::class);
        Route::post('staffs/ban/{id}', [StaffController::class, 'ban'])->name('staffs.ban'); //Ban nhân viên
        Route::post('staffs/unban/{id}', [StaffController::class, 'unban'])->name('staffs.unban'); //Unban nhân viên
        Route::get('staffs/history/{id}', [StaffController::class, 'history'])->name('staffs.history'); //Lịch sử ban/unban
        Route::get('staffs/permission/{user}', [StaffController::class, 'permission'])->name('staffs.permission'); //Quyền nhân viên
        Route::post('staffs/permission/{user}/{managerSetting}/toggle', [StaffController::class, 'togglePermission'])->name('staffs.permissions.toggle'); // Cập nhật quyền của nhân viên

        //Quản lý manager setting
        Route::resource('managerSettings', ManagerSettingController::class);
    // });

    // Route cho staff (admin cũng có thể truy cập)
    // Route::middleware(['role:staff|admin'])->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        // Các chức năng staff có thể quản lý

    //Quản lý sản phẩm
    Route::resource('products', ProductController::class);
    Route::post('products/getAllCategories', action: [ProductController::class, 'getAllCategories'])->name('getAllCategories');
    Route::post('products/createNewCategory', action: [ProductController::class, 'createNewCategory'])->name('createNewCategory');
    Route::post('products/getAllBrands', action: [ProductController::class, 'getAllBrands'])->name('getAllBrands');
    Route::post('products/createNewBrand', action: [ProductController::class, 'createNewBrand'])->name('createNewBrand');
    Route::post('products/getAllAttributes', action: [ProductController::class, 'getAllAttributes'])->name('getAllAttributes');
    Route::post('products/getSkuProduct', action: [ProductController::class, 'getSkuProduct'])->name('getSkuProduct');
    Route::post('products/getSkuProductVariation', action: [ProductController::class, 'getSkuProductVariation'])->name('getSkuProductVariation');
    Route::post('products/getAllAttributeValuesById/{id}', action: [ProductController::class, 'getAllAttributeValuesById'])->name('getAllAttributeValuesById');
    Route::post('products/addNewAttributeValueById/{id}', action: [ProductController::class, 'addNewAttributeValueById'])->name('addNewAttributeValueById');
      

        //Quản lý danh mục
        Route::middleware(['checkPermission:Quản lý danh mục'])->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::get('categories/product/{id}', [CategoryController::class, 'product'])->name('categories.product');
            Route::post('categories/updateBestSelling', [CategoryController::class, 'updateBestSelling'])->name('categories.updateBestSelling');
            Route::delete('categories/{id}/remove', [CategoryController::class, 'remove'])->name('categories.remove');
        });


        //Quản lý sản phẩm
        // Route::middleware(['checkPermission:Quản lý sản phẩm'])->group(function () {
            Route::resource('products', ProductController::class);
            Route::post('products/getAttributes', action: [ProductController::class, 'getAllAttributes'])->name('getAllAttributes');
        // });

        //Quản lý thuộc tính
        // Route::middleware(['checkPermission:Quản lý thuộc tính'])->group(function () {
            Route::resource('attributes', AttributeController::class);
            //Quản lý loại thuộc tính
            Route::resource('attribute_types', AttributeTypeController::class);
            //Quản lý dữ liệu thuộc tính
            Route::resource('attribute_values', AttributeValueController::class);
        // });

        //quản lý thương thiệu(brand)
        Route::middleware(['checkPermission:Quản lý thuộc tính'])->group(function () {
            Route::resource('brands', BrandController::class);
        });

        //Quản lý banner
        // Route::middleware(['checkPermission:Quản lý banner'])->group(function () {
            Route::resource('banner', BannerController::class);
            Route::get('banner/onactive/{id}', [BannerController::class, 'onActive'])->name('banner.onactive');
            Route::get('banner/offactive/{id}', [BannerController::class, 'offActive'])->name('banner.offactive');
        // });

        //Quản lý vouchers
        Route::middleware(['checkPermission:Quản lý vouchers'])->group(function () {
            Route::resource('vouchers', VoucherController::class);
            Route::get('vouchers/onactive/{id}', [VoucherController::class, 'onActive'])->name('vouchers.onactive');
            Route::get('vouchers/offactive/{id}', [VoucherController::class, 'offActive'])->name('vouchers.offactive');
        });

        //Quản lý khách hàng
        // Route::middleware(['checkPermission:Quản lý khách hàng'])->group(function () {
            Route::resource('customers', CustomerController::class);
        // });
    });
// });

// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });
Route::resource('attributes', AttributeController::class);
//Quản lý loại thuộc tính
Route::resource('attribute_types', AttributeTypeController::class);
//Quản lý dữ liệu thuộc tính
Route::resource('attribute_values', AttributeValueController::class);

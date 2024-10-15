<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\admin\AttributeTypeController;

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
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    //Quản lý danh mục
    Route::resource('categories', CategoryController::class);

    //Quản lý sản phẩm
    Route::resource('products', ProductController::class);
    Route::post('products/getAttributes', action: [ProductController::class, 'getAllAttributes'])->name('getAllAttributes');

    //Quản lý thuộc tính
    Route::resource('attributes', AttributeController::class);

    //Quản lý loại thuộc tính
    Route::resource('attribute_types', AttributeTypeController::class);

    //Quản lý banner
    Route::resource('banner', BannerController::class);
    Route::get('banner/onactive/{id}', [BannerController::class, 'onActive'])->name('banner.onactive');
    Route::get('banner/offactive/{id}', [BannerController::class, 'offActive'])->name('banner.offactive');
});

// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

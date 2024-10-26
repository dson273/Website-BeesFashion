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
    Route::post('products/getAllCategories', action: [ProductController::class, 'getAllCategories'])->name('getAllCategories');
    Route::post('products/getAttributes', action: [ProductController::class, 'getAllAttributes'])->name('getAllAttributes');
    Route::post('products/createNewCategory', action: [ProductController::class, 'createNewCategory'])->name('createNewCategory');
    Route::post('products/getSkuProduct', action: [ProductController::class, 'getSkuProduct'])->name('getSkuProduct');
    Route::post('products/getSkuProductVariation', action: [ProductController::class, 'getSkuProductVariation'])->name('getSkuProductVariation');
    Route::post('products/getAllAttributeValuesById/{id}', action: [ProductController::class, 'getAllAttributeValuesById'])->name('getAllAttributeValuesById');
    Route::post('products/addNewAttributeValueById/{id}', action: [ProductController::class, 'addNewAttributeValueById'])->name('addNewAttributeValueById');

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

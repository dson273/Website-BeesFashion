<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\admin\AttributeTypeController;
use App\Http\Controllers\admin\ImportHistoryController;
use App\Http\Controllers\admin\AttributeValueController;
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
    Route::middleware(['role:admin'])->group(function () {
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
    });

    // Route cho staff (admin cũng có thể truy cập)
    Route::middleware(['role:staff|admin'])->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        // Các chức năng staff có thể quản lý

        //=======================================================Quản lý sản phẩm============================================================
        Route::middleware(['checkPermission:Quản lý sản phẩm'])->group(function () {
            //List product
            Route::get('products/inactive', [ProductController::class, 'inactive'])->name(name: 'products.index.inactive');
            Route::get('products/changestatusproduct/{id}', [ProductController::class, 'changeStatusProduct'])->name('products.index.changestatus');
            Route::get('products/changestatusproductvariant/{id}', [ProductController::class, 'changeStatusProductVariant'])->name('products.show.changestatus');
            Route::resource('products', ProductController::class);
            Route::post('product/importingGoods', [ProductController::class, 'importingGoods'])->name('importingGoods');
            //Create and edit product
            Route::post('products/getAllCategories', action: [ProductController::class, 'getAllCategories'])->name('getAllCategories');
            Route::post('products/createNewCategory', action: [ProductController::class, 'createNewCategory'])->name('createNewCategory');
            Route::post('products/checkCategoryById', action: [ProductController::class, 'checkCategoryById'])->name('checkCategoryById');

            Route::post('products/getAllBrands', action: [ProductController::class, 'getAllBrands'])->name('getAllBrands');
            Route::post('products/createNewBrand', action: [ProductController::class, 'createNewBrand'])->name('createNewBrand');
            Route::post('products/checkBrandById', action: [ProductController::class, 'checkBrandById'])->name('checkBrandById');

            Route::post('products/getAllAttributes', action: [ProductController::class, 'getAllAttributes'])->name('getAllAttributes');

            Route::post('products/getProductSku', action: [ProductController::class, 'getProductSku'])->name('getProductSku');

            Route::post('products/getProductVariationSku', action: [ProductController::class, 'getProductVariationSku'])->name('getProductVariationSku');

            Route::post('products/getAllAttributeValuesById', action: [ProductController::class, 'getAllAttributeValuesById'])->name('getAllAttributeValuesById');
            Route::post('products/addNewAttributeValueById', action: [ProductController::class, 'addNewAttributeValueById'])->name('addNewAttributeValueById');

            //Edit product
            Route::post('products/getOldProductData', action: [ProductController::class, 'getOldProductData'])->name('getOldProductData');
        });

        //=======================================================Quản lý danh mục=======================================================
        Route::middleware(['checkPermission:Quản lý danh mục'])->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::get('categories/product/{id}', [CategoryController::class, 'product'])->name('categories.product');
            Route::post('categories/{id}/updateBestSelling', [CategoryController::class, 'updateBestSelling'])->name('categories.updateBestSelling');
            Route::delete('categories/{categoryId}/products/{productId}/remove', [CategoryController::class, 'remove'])->name('categories.remove');
            Route::post('categories/{id}/fake_sales', [CategoryController::class, 'fake_sales'])->name('categories.fake_sales');
        });

        //=======================================================Quản lý thuộc tính=======================================================
        Route::middleware(['checkPermission:Quản lý thuộc tính'])->group(function () {
            Route::resource('attributes', AttributeController::class);
            //Quản lý loại thuộc tính
            Route::resource('attribute_types', AttributeTypeController::class);
            //Quản lý dữ liệu thuộc tính
            Route::resource('attribute_values', AttributeValueController::class);
        });

        //=======================================================Quản lý thương thiệu(brand)=======================================================
        Route::middleware(['checkPermission:Quản lý thương hiệu'])->group(function () {
            Route::resource('brands', BrandController::class);
        });

        //=======================================================Quản lý banner=======================================================
        Route::middleware(['checkPermission:Quản lý banner'])->group(function () {
            Route::resource('banner', BannerController::class);
            Route::get('banner/onactive/{id}', [BannerController::class, 'onActive'])->name('banner.onactive');
            Route::get('banner/offactive/{id}', [BannerController::class, 'offActive'])->name('banner.offactive');
        });

        //=======================================================Quản lý vouchers=======================================================
        // Route::middleware(['checkPermission:Quản lý vouchers'])->group(function () {
        Route::resource('vouchers', VoucherController::class);
        Route::post('vouchers/addProductVoucher', [VoucherController::class, 'addProductVoucher'])->name('vouchers.addProductVoucher');
        Route::delete('vouchers/remove/{productId}/{voucherId}', [VoucherController::class, 'remove'])->name('vouchers.remove');
        Route::get('vouchers/onactive/{id}', [VoucherController::class, 'onActive'])->name('vouchers.onactive');
        Route::get('vouchers/offactive/{id}', [VoucherController::class, 'offActive'])->name('vouchers.offactive');
        // });


        Route::resource('orders', OrderController::class);
        Route::get('orders/info/{id}', [OrderController::class, 'show'])->name('orders.info');
        Route::get('orders/print/{id}', [OrderController::class, 'printOrder'])->name('orders.print');
        Route::get('orders/success/{id}', [OrderController::class, 'onSuccess'])->name('orders.success');
        Route::get('orders/active/{id}', [OrderController::class, 'onActive'])->name('orders.active');
        Route::get('orders/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('orders.cancel');



        Route::resource('import_history', ImportHistoryController::class);
        Route::post('import_history/update', [ImportHistoryController::class, 'updateQuantity'])->name('import_history.update');





        //=======================================================Quản lý khách hàng=======================================================
        Route::middleware(['checkPermission:Quản lý khách hàng'])->group(function () {
            Route::resource('customers', CustomerController::class);
            Route::post('customers/ban/{id}', [CustomerController::class, 'ban'])->name('customers.ban'); //Ban nhân viên
            Route::post('customers/unban/{id}', [CustomerController::class, 'unban'])->name('customers.unban'); //Unban nhân viên
            Route::get('customers/history/{id}', [CustomerController::class, 'history'])->name('customers.history'); //Lịch sử ban/unban
        });
    });
    //Thống kê shop
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics/revenue', [DashboardController::class, 'getRevenue']); //Thống kê doanh thu

    Route::get('/statistics/revenueProduct', [StatisticalController::class, 'revenueByProduct'])->name('statistics.revenueProduct'); //Thống kê doanh thu sản phẩm
    Route::get('/statistics/cart-statistics', [StatisticalController::class, 'statisticCart'])->name('statistics.cart-statistics'); //Thống kê sản phẩm trong giỏ hàng
    Route::get('/statistics/product_views', [StatisticalController::class, 'product_views'])->name('statistics.product_views'); //Thống kê lượt xem
    Route::get('/statistics/revenueBrand', [StatisticalController::class, 'revenueByBrand'])->name('statistics.revenueBrand'); //Thống kê doanh thu thương hiệu
    Route::get('/statistics/revenueCustomer', [StatisticalController::class, 'revenueByCustomer'])->name('statistics.revenueCustomer'); //Thống kê doanh thu theo khách hàng
});

// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

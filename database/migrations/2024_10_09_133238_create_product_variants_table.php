<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('SKU')->unique()->comment('Mã sản phẩm biến thể');
            $table->string('name')->comment('Tên sản phẩm biến thể');
            $table->string('image')->nullable()->comment('Ảnh sản phẩm biến thể');
            $table->bigInteger('display_import_price')->comment('Giá nhập để hiển thị cho khách hàng. Đây là giá bạn muốn khách hàng biết.');
            $table->bigInteger('sale_price')->nullable()->comment('Giá bán của sản phẩm, là giá cuối cùng mà khách hàng sẽ thấy');
            $table->integer('stock')->comment('Tồn kho');
            $table->foreignIdFor(Product::class)->comment('Xác định biến thể thuộc sản phẩm nào')->constrained();
            $table->tinyInteger('is_active')->default(1)->comment('Trạng thái hoạt động, mặc định là 1(đã kích hoạt)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

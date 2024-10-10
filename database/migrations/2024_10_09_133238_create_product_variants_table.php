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
            $table->string('SKU')->comment('Mã sản phẩm biến thể');
            $table->string('name')->comment('Tên sản phẩm biến thể');
            $table->string('image')->nullable()->comment('Ảnh sản phẩm biến thể');
            $table->string('sale_price')->nullable()->comment('Giá bán');
            $table->integer('stock')->comment('Tồn kho');
            $table->foreignIdFor(Product::class)->constrained()->comment('Xác định biến thể thuộc sản phẩm nào');
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

<?php

use App\Models\Product;
use App\Models\Voucher;
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
        Schema::create('product_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->comment('Xác định sản phẩm nào được áp dụng voucher này');
            $table->foreignIdFor(Voucher::class)->constrained()->comment('Xác định voucher nào được sản phẩm áp dụng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_vouchers');
    }
};

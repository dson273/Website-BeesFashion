<?php

use App\Models\User;
use App\Models\User_shipping_address;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('total_cost')->comment('Tổng số tiền khi chưa áp dụng mã giảm');
            $table->integer('shipping_price')->comment('Số tiền vận chuyển');
            $table->integer('shipping_voucher')->default(0)->comment('Số tiền vận chuyện được giảm');
            $table->integer('voucher')->default(0)->comment('Số tiền được giảm từ voucher');
            $table->integer('total_payment')->comment('Tổng tiền thanh toán cuối cùng');
            $table->foreignIdFor(User::class)->constrained()->comment('Xác định người dùng nào đã đặt hàng');
            $table->foreignIdFor(User_shipping_address::class)->constrained()->comment('Xác định địa chỉ nào mà người dùng chọn để đặt hàng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

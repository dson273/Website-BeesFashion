<?php

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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên voucher');
            $table->string('code')->comment('Mã voucher');
            $table->integer('amount')->comment('Giá trị giảm');
            $table->integer('quantity')->comment('Số lượng voucher');
            $table->string('image')->comment('Ảnh voucher');
            $table->enum('type', ['fixed', 'percent', 'free_ship'])->comment('Loại voucher, ở đây có 3 loại là cố định ví dụ 100k, phần trăm và miễn phí vận chuyển');
            $table->date('start_date')->nullable()->comment('Thời gian bắt đầu có thể sử dụng được voucher');
            $table->date('end_date')->nullable()->comment('Thời gian voucher hết hiệu lực');
            $table->integer('minimum_order_value')->nullable()->comment('Giá tiền tối thiểu của đơn hàng');
            $table->tinyInteger('is_active')->default(1)->comment('Trạng thái kích hoạt voucher, mặc định là 1(đã kích hoạt)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};

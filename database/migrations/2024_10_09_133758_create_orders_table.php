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
            $table->integer('total_cost');
            $table->integer('shipping_price');
            $table->integer('shipping_voucher')->default(0);
            $table->integer('voucher')->default(0);
            $table->integer('total_payment');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(User_shipping_address::class)->constrained();
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

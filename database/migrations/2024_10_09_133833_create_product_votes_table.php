<?php

use App\Models\Order_detail;
use App\Models\Product_variant;
use App\Models\User;
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
        Schema::create('product_votes', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->float('star');
            $table->boolean("status")->default(false);
            $table->boolean('edit')->default(false);
            $table->foreignIdFor(Product_variant::class)->constrained();
            $table->foreignIdFor(Order_detail::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_votes');
    }
};

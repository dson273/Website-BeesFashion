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
        Schema::create('manager_settings', function (Blueprint $table) {
            $table->id();
            $table->string('manager_name')->comment('Tên chức năng quản lý');
            $table->foreignId('parent_manager_setting_id')->nullAble()->comment('Xác định chức năng quản trị cha')->constrained('manager_settings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_settings');
    }
};

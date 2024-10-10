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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->comment('Tên đăng nhập');
            $table->string('email')->unique()->comment('Email của người dùng');
            $table->timestamp('email_verified_at')->nullable()->comment('Email đã được xác minh lúc nào');
            $table->string('password')->comment('Mật khẩu');
            $table->enum('role', ['member', 'staff', 'admin'])->default('member')
            ->comment('Vai trò của người dùng, ở đây có 3 vai trò: người dùng, nhân viên và admin, admin lớn nhất');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

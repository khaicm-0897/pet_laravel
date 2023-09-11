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
            $table->increments('id');
            $table->string('phone')->unique()->comment('Số điện thoại');
            $table->string('password')->comment('Mật khẩu');
            $table->string('name')->comment('Họ và tên');
            $table->string('email')->unique()->comment('Email');
            $table->unsignedTinyInteger('status')->default(1)->comment('TT: 1 Hoạt động, 2 Bị khoá');
            $table->string('avatar')->nullable()->comment('Ảnh đại diện');
            $table->unsignedTinyInteger('gender')->nullable()->comment('Giới tính: 1 Nam, 2 Nữ');
            $table->date('birthday')->nullable()->comment('Ngày sinh');
            $table->tinyInteger('position_id')->default(1)->comment('1: Admin, 2: Nhân viên');
            $table->string('address')->nullable()->comment('Địa chỉ');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Trường user_id tự động tăng
            $table->string('username')->unique(); // Tên đăng nhập
            $table->string('password'); // Mật khẩu
            $table->string('email')->unique(); // Địa chỉ email
            $table->string('full_name'); // Họ tên đầy đủ
            $table->string('address')->nullable(); // Địa chỉ người dùng
            $table->string('phone')->nullable(); // Số điện thoại
            $table->enum('role', ['customer', 'admin'])->default('customer'); // Quyền hạn
            $table->string('image')->nullable(); // Hình đại diện
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

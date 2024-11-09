<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('post_id'); // Khóa chính tự động tăng
            $table->unsignedInteger('user_id'); // Khóa ngoại tới bảng users
            $table->string('title'); // Tiêu đề bài viết
            $table->text('content'); // Nội dung bài viết
            $table->string('image')->nullable(); // Hình ảnh bài viết (có thể rỗng)
            $table->timestamps(); // Thời gian tạo và cập nhật bài viết

            // Khóa ngoại tới bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs'); // Xóa bảng blogs khi rollback
    }
}

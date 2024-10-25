<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('post_id'); // Trường post_id tự động tăng
            $table->unsignedBigInteger('user_id'); // Trường user_id
            $table->string('title', 255); // Tiêu đề bài viết
            $table->text('content'); // Nội dung bài viết
            $table->string('image', 255)->nullable(); // Đường dẫn hình ảnh
            $table->timestamps(); // Thời gian tạo và cập nhật
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // Khóa ngoại
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id('color_id'); // khóa chính, tự động tăng
            $table->string('images', 255)->nullable(); // ảnh bảng màu (cho phép null)
            // $table->string('name', 30);
            $table->string('name', 30)->fulltext();
            $table->timestamps(); // thêm thời gian tạo và cập nhật
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
        

    }
};

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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id'); // khóa chính, tự động tăng
            $table->string('product_name', 255); // tên sản phẩm
            $table->text('description'); // mô tả sản phẩm
            $table->double('price'); // giá sản phẩm
            $table->integer('quantity'); // số lượng sản phẩm
            $table->unsignedBigInteger('category_id'); // mã danh mục, khóa ngoại
            $table->unsignedBigInteger('color_id'); // mã màu, khóa ngoại
            $table->string('image1', 255)->nullable(); // ảnh sản phẩm 1
            $table->string('image2', 255)->nullable(); // ảnh sản phẩm 2
            $table->string('image3', 255)->nullable(); // ảnh sản phẩm 3
            $table->tinyInteger('rating')->default(0); // điểm đánh giá sản phẩm
            $table->timestamps(); // thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_items_id');  // Khóa chính tự tăng
            $table->unsignedBigInteger('order_id');  // Khóa ngoại tới orders(order_id)
            $table->unsignedBigInteger('product_id');  // Khóa ngoại tới products(product_id)
            $table->unsignedInteger('quantity');  // Số lượng sản phẩm
            $table->double('price');  // Giá sản phẩm tại thời điểm mua
            $table->timestamps();  // Tạo các cột created_at và updated_at tự động

            // Khóa ngoại tới bảng orders
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');

            // Khóa ngoại tới bảng products
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

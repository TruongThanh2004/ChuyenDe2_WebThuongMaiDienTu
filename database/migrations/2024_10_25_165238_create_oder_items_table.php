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
            $table->id('order_items_id'); // Khóa chính
            $table->unsignedBigInteger('order_id'); // Khóa ngoại tới bảng Orders
            $table->unsignedBigInteger('product_id'); // Khóa ngoại tới bảng Products
            $table->integer('quantity')->default(1);
            $table->double('price', 10, 2); // Giá tại thời điểm đặt hàng
            $table->timestamps(); // Tạo cột created_at và updated_at

            // Định nghĩa khóa ngoại
            // $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            // $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
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

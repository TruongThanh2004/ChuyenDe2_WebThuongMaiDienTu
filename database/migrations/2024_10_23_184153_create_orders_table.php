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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');  // Khóa chính tự tăng
            $table->unsignedInteger('user_id');  // Khóa ngoại tới users(id)
            $table->unsignedBigInteger('product_id');  // Khóa ngoại tới products(product_id)
            $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->double('total_amount');
            $table->timestamps();  // Tạo các cột created_at và updated_at tự động
    
            // Khóa ngoại tới bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Khóa ngoại tới bảng products
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

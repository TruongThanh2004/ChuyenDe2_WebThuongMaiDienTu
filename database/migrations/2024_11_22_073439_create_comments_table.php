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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name'); // Tên người bình luận
            $table->text('comment'); // Nội dung bình luận
            $table->timestamps();
    
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->unsignedInteger('user_id'); // hoặc bigInteger nếu id của users là bigIncrements
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Đảm bảo khóa ngoại
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

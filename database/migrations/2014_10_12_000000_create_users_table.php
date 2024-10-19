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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('username');
            $table->string('fullname');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('phone');
            $table->integer('role');
            $table->timestamp('email_verified_at')->nullable();       
>>>>>>> CRUD_User
>>>>>>> main
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

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
<<<<<<< HEAD
            $table->increments('id');
            $table->string('image',191);
            $table->string('username',191);
            $table->string('fullname',191);
            $table->string('password',191);
            $table->string('email',191)->unique();
            $table->string('address',191);
            $table->string('phone',191);
            $table->integer('role');
            $table->timestamp('email_verified_at')->nullable();       
=======
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
>>>>>>> CRUD_Blog
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

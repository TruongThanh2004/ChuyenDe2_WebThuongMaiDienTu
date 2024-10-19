<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {     
        DB::table('users')->insert([
            'image'=>'1.png',
            'username' => 'User',
            'fullname' => 'Test User',
            'password'=>'123',
            'email' => 'test@example.com',
            'address'=>'sansiajs',
            'phone'=>'123456789',
            'role'=>1,
        ]);
    }
}
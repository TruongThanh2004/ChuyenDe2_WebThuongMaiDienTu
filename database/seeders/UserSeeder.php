<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'image' => 'user.jpg',
                'username' => 'admin',
                'fullname' => 'Do Truong Thanh',
                'password' => Hash::make('admin123'),
                'email' => 'thanhdoken113@gmail.com',
                'address' => 'abc',
                'phone' => '1234567890',
                'role' => 2,
            ],[
                'image' => 'user.jpg',
                'username' => 'admin1',
                'fullname' => 'Do Truong Thanh',
                'password' => Hash::make('admin123'),
                'email' => 'thanhdoken@gmail.com',
                'address' => 'abc',
                'phone' => '1234567890',
                'role' => 1,
            ],[
                'image' => 'user.jpg',
                'username' => 'user',
                'fullname' => 'Do Truong Thanh',
                'password' => Hash::make('admin123'),
                'email' => 'thanhdo@gmail.com',
                'address' => 'abc',
                'phone' => '1234567890',
                'role' => 1,
            ],[
                'image' => 'user.jpg',
                'username' => 'user1',
                'fullname' => 'Do Truong Thanh',
                'password' => Hash::make('admin123'),
                'email' => 'thanhdo1@gmail.com',
                'address' => 'abc',
                'phone' => '1234567890',
                'role' => 1,
            ],[
                'image' => 'user.jpg',
                'username' => 'user2',
                'fullname' => 'Do Truong Thanh',
                'password' => Hash::make('admin123'),
                'email' => 'thanhdo2@gmail.com',
                'address' => 'abc',
                'phone' => '1234567890',
                'role' => 1,
            ],[
                'image' => 'user.jpg',
                'username' => 'user',
                'fullname' => 'Do Truong Thanh',
                'password' => Hash::make('admin123'),
                'email' => 'thanhdo3@gmail.com',
                'address' => 'abc',
                'phone' => '1234567890',
                'role' => 1,
            ]
        ]);
    }
}

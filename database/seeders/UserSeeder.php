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
            'image'=>'user.jpg',
            'username' => 'admin',
            'fullname' => 'Do Truong Thanh',
            'password'=>Hash::make('admin123'),
            'email' => 'thanhdoken113@gmail.com',
            'address'=>'abc',
            'phone'=>'123456789',
            'role'=>2,
        ]);
    }
}

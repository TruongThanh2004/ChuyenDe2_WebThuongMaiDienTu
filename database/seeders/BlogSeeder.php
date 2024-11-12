<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'user_id' => 1,
                'title' => 'Blog Post 1',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 2',
                'content' => Str::random(200),
                'image' => '1729512032.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 3',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 4',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 5',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 6',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 7',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 8',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 9',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 10',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 11',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 12',
                'content' => Str::random(200),
                'image' => '1729903057.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

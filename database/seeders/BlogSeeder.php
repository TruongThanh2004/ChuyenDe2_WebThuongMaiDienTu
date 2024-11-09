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
                'image' => 'example1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 2',
                'content' => Str::random(200),
                'image' => 'example2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 3',
                'content' => Str::random(200),
                'image' => 'example3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 4',
                'content' => Str::random(200),
                'image' => 'example4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 5',
                'content' => Str::random(200),
                'image' => 'example5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 6',
                'content' => Str::random(200),
                'image' => 'example6.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 7',
                'content' => Str::random(200),
                'image' => 'example7.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 8',
                'content' => Str::random(200),
                'image' => 'example8.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 9',
                'content' => Str::random(200),
                'image' => 'example9.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 10',
                'content' => Str::random(200),
                'image' => 'example10.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 11',
                'content' => Str::random(200),
                'image' => 'example11.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 12',
                'content' => Str::random(200),
                'image' => 'example12.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

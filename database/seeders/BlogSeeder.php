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
                'image' => '1729300348.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 2',
                'content' => Str::random(200),
                'image' => '1729303888.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 3',
                'content' => Str::random(200),
                'image' => '1729508245.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 4',
                'content' => Str::random(200),
                'image' => '1729512032.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 5',
                'content' => Str::random(200),
                'image' => '1729566297.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 6',
                'content' => Str::random(200),
                'image' => '1729902670.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 7',
                'content' => Str::random(200),
                'image' => '1729902954.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 8',
                'content' => Str::random(200),
                'image' => '1729903166.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 9',
                'content' => Str::random(200),
                'image' => '1729903255.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 10',
                'content' => Str::random(200),
                'image' => '1729903334.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Blog Post 11',
                'content' => Str::random(200),
                'image' => '1729908868.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Blog Post 12',
                'content' => Str::random(200),
                'image' => '1729912717.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

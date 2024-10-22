<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_name' => 'Iphone',
            ],

            [
                'category_name' => 'SamSung',
            ],

            [
                'category_name' => 'Vivo',
            ],

            [
                'category_name' => 'Xiaomi',
            ],

            [
                'category_name' => 'Oppo',
            ],

            [
                'category_name' => 'Huawei',
            ],
        ]);
    }
}

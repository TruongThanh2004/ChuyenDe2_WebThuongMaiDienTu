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
                'name' => 'Iphone',
            ],

            [
                'name' => 'SamSung',
            ],

            [
                'name' => 'Vivo',
            ],

            [
                'name' => 'Xiaomi',
            ],

            [
                'name' => 'Oppo',
            ],

            [
                'name' => 'Huawei',
            ],
        ]);
    }
}

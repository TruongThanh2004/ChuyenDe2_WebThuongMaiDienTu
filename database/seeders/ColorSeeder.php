<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color; // Thêm dòng này để import model Color

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách các màu mẫu
        $colors = [
            ['name' => 'Đỏ', 'images' => 'images/colors/1729540040.png'],
            ['name' => 'Xanh dương', 'images' => 'images/colors/1729540210.png'],
            ['name' => 'Xanh lá', 'images' => 'images/colors/1729540241.png'],
            ['name' => 'Vàng', 'images' => 'images/colors/yellow.png'],
            ['name' => 'Đen', 'images' => 'images/colors/black.png'],
            ['name' => 'Trắng', 'images' => 'images/colors/white.png'],
        ];

        // Chèn các màu vào bảng colors
        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}

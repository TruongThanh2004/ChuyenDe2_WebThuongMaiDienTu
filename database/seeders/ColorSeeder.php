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
            ['name' => ' Màu Đỏ', 'images' => 'images/colors/1729540241.png'],
            ['name' => ' Màu Xanh dương', 'images' => 'images/colors/1729540210.png'],
            ['name' => ' Màu Xanh lá', 'images' => 'images/colors/1729540241.png'],
            ['name' => ' Màu Vàng', 'images' => 'images/colors/1729566084.png'],
            ['name' => ' Màu Đen', 'images' => 'images/colors/1729788832.png'],
            ['name' => 'Màu Trắng', 'images' => 'images/colors/1729789084.png'],
        ];

        // Chèn các màu vào bảng colors
        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}

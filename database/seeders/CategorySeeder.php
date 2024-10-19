<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Import model Category

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách các thể loại mẫu
        $categories = [
            ['category_name' => 'Điện tử'],
            ['category_name' => 'Thời trang'],
            ['category_name' => 'Đồ gia dụng'],
            ['category_name' => 'Sức khỏe'],
            ['category_name' => 'Thể thao'],
            ['category_name' => 'Đồ ăn'],
        ];

        // Chèn các thể loại vào bảng categories
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

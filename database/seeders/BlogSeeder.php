<?php
use Illuminate\Database\Seeder;
use App\Models\Blog; // Thay 'Blog' bằng model bạn đang sử dụng cho bảng blog.

class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::create([
            'user_id' => 1, // Thay thế bằng ID người dùng phù hợp.
            'title' => 'Bài viết đầu tiên',
            'content' => 'Nội dung của bài viết đầu tiên.',
            'image' => 'path/to/image.jpg'
        ]);

        Blog::create([
            'user_id' => 2,
            'title' => 'Bài viết thứ hai',
            'content' => 'Nội dung của bài viết thứ hai.',
            'image' => 'path/to/image2.jpg'
        ]);
    }
}

?>
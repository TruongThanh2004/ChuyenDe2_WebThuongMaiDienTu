<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Hiển thị danh sách blog
    public function index()
    {
        $blogs = Blog::all(); // Lấy tất cả bài viết từ database
        return view('blogs.index')->with('blogs',$blogs); // Đảm bảo tên view và biến đúng
    }

    // Hiển thị form thêm bài viết
    public function create()
    {
        $users = User::all(); // Lấy tất cả người dùng
        return view('blogs.create', compact('users'));
    }


    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        // Sử dụng try-catch để bắt các lỗi phát sinh
        try {
            // Khởi tạo mảng để lưu thông tin blog
            $blogData = [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id,
            ];

            // Xử lý hình ảnh
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/blog'), $imageName);
                $blogData['image'] = $imageName; // Lưu đường dẫn tương đối
            }

            // Tạo blog mới
            Blog::create($blogData);

            // Nếu thành công, chuyển hướng với thông báo thành công
            return redirect()->route('blogs.index')->with('success', 'Blog đã được thêm thành công.');
        } catch (\Exception $e) {
            // Nếu có lỗi, chuyển hướng với thông báo lỗi
            return redirect()->route('blogs.create')->with('error', 'Đã xảy ra lỗi khi thêm blog: ' . $e->getMessage());
        }
    }






    // Hiển thị form sửa bài viết
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $users = User::all();
        return view('blogs.edit', compact('blog', 'users'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'image' => 'nullable|image|max:2048', // Đảm bảo hình ảnh có định dạng hợp lệ
    ]);

    $blog = Blog::findOrFail($id);
    $data = $request->all();

    // Xử lý hình ảnh
    if ($request->hasFile('image')) {
        // Xóa hình ảnh cũ nếu có
        if ($blog->image) {
            // Xóa hình ảnh khỏi thư mục
            $oldImagePath = public_path('images/blog/' . $blog->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Xóa hình ảnh cũ
            }
        }

        // Lưu hình ảnh mới
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/blog'), $imageName);
        $data['image'] = $imageName; // Lưu tên file mới
            } else {
                // Nếu không tải lên hình ảnh mới, giữ nguyên hình ảnh cũ
                $data['image'] = $blog->image;
            }

            // Cập nhật blog
            $blog->update($data);

            return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
        }


    

        public function destroy($id)
        {
            $blog = Blog::findOrFail($id);
        
            // Kiểm tra xem blog có hình ảnh hay không
            if ($blog->image) {
                // Xóa hình ảnh khỏi thư mục
                $imagePath = public_path('images/blog/' . $blog->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa hình ảnh khỏi thư mục
                }
            }
        
            // Xóa blog khỏi cơ sở dữ liệu
            $deleted = $blog->delete();
        
            if ($deleted) {
                return redirect()->route('blogs.index')->with('success', 'Blog đã được xóa thành công.');
            } else {
                return redirect()->route('blogs.index')->with('error', 'Không thể xóa blog, vui lòng thử lại.');
            }
        }
    }



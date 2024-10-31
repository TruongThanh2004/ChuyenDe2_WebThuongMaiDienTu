<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
     // Hiển thị danh sách blog
     public function index(Request $request)
     {
         $search = $request->input('search', ''); // Lấy giá trị tìm kiếm từ request
 
         // Tìm kiếm và phân trang
         $blogs = Blog::when($search, function ($query) use ($search) {
             return $query->where('title', 'LIKE', "%{$search}%");
         })->paginate(5); // Phân trang với 5 bài viết mỗi trang
 
         // Trả về view kèm biến $blogs và $search
         return view('admin.blogs.index', compact('blogs', 'search'));
     }
 
     // Hiển thị form thêm bài viết
     public function create()
     {
         $user = auth()->user(); // Lấy thông tin người dùng hiện tại
         return view('admin.blogs.create', compact('user'));
     }
 
     public function store(Request $request)
     {
         // Xác thực dữ liệu
         $validatedData = $request->validate([
             'title' => 'required|string|max:255',
             'content' => 'required|string',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         // Gán user_id từ người dùng hiện tại
         $validatedData['user_id'] = auth()->id(); 
 
         try {
             // Khởi tạo mảng để lưu thông tin blog
             $blogData = [
                 'title' => $validatedData['title'],
                 'content' => $validatedData['content'],
                 'user_id' => $validatedData['user_id'],
             ];
 
             // Xử lý hình ảnh
             if ($request->hasFile('image')) {
                 $imageName = time() . '.' . $request->image->extension();
                 $request->image->move(public_path('images/blog'), $imageName);
                 $blogData['image'] = $imageName;
             }
 
             // Tạo blog mới
             Blog::create($blogData);
 
             // Chuyển hướng thành công
             return redirect()->route('blogs.index')->with('success', 'Blog đã được thêm thành công.');
         } catch (\Exception $e) {
             // Chuyển hướng với thông báo lỗi
             return redirect()->route('blogs.create')->with('error', 'Đã xảy ra lỗi khi thêm blog: ' . $e->getMessage());
         }
     }
 
     // Hiển thị form sửa bài viết
     public function edit($id)
     {
         $blog = Blog::findOrFail($id);
         $users = User::all();
         return view('admin.blogs.edit', compact('blog', 'users'));
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
 
         return redirect()->route('blogs.index')->with('success', 'Blog đã được cập nhật thành công.');
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
 
     public function show($id)
     {
         $blog = Blog::with('user')->findOrFail($id); // Tìm bài viết cùng với thông tin người dùng
         return view('admin.blogs.show', compact('blog'));
     }

        

    }
    


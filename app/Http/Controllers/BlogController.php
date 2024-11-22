<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        // Lấy danh sách blog và phân trang
        $blogs = Blog::paginate(10);

        // Trả về view hiển thị danh sách blog
        return view('admin.blogs.index', compact('blogs'));
    }
    public function show($id)
    {
        // Tìm blog theo ID
        $blog = Blog::with('user')->findOrFail($id);

        // Trả về view hiển thị chi tiết blog
        return view('admin.blogs.show', compact('blog'));
    }
    /**
     * Hiển thị danh sách blog cho trang chủ.
     */
    public function showBlogsForHome()
    {
        // Lấy các blog đã phân trang
        $blogs = Blog::getBlogsForHome();

        return view('home.blog', $blogs);
    }

    /**
     * Hiển thị chi tiết blog.
     */
    public function showFullBlogs($post_id)
    {
        // Lấy blog với post_id
        $blog = Blog::findOrFail($post_id);
        
        // Trả về view với dữ liệu blog
        return view('home.showbl', compact('blog'));
    }
    /**
     * Hiển thị form tạo blog.
     */
    public function create()
    {
        $users = User::all();  // Lấy danh sách người dùng
        return view('admin.blogs.create', compact('users'));
    }


    /**
     * Lưu blog mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Gọi phương thức createBlog từ model Blog để tạo blog mới
        $blog = Blog::createBlog($request);
    
        // Quay lại trang danh sách blog hoặc chuyển hướng
        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }
    
   
    /**
     * Hiển thị form chỉnh sửa blog.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $users = User::all();  // Lấy danh sách người dùng
        return view('admin.blogs.edit', compact('blog', 'users'));
    }

    /**
     * Cập nhật blog.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->updateBlog($request);
        return redirect()->route('blogs.index');
    }
    public function destroy($id)
    {
        $result = Blog::deleteBlog($id);  // Gọi phương thức xóa từ model

        if ($result) {
            return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
        } else {
            return redirect()->route('blogs.index')->with('error', 'Blog not found!');
        }
    }

    /**
     * Tìm kiếm và lọc blog.
     */
    public function filterBlogs(Request $request)
    {
        // Lọc blog theo từ khóa tìm kiếm và danh mục
        $searchTerm = $request->get('search');
        $categoryIds = $request->get('category_ids');
        $sort = $request->get('sort', 'asc');

        $blogs = Blog::getFilteredAndSortedBlogs($searchTerm, $categoryIds, $sort);

        return view('home.blog', compact('blogs'));
    }
    
}

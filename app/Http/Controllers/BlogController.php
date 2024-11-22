<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
        $blogs = Blog::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('content', 'LIKE', '%' . $search . '%');
        })->paginate(10); // Thực hiện tìm kiếm và phân trang

        return view('admin.blogs.index', compact('blogs', 'search'));
    }
  
    public function show($hashid)
    {
        // Giải mã ID từ Hashids
        $decodedId = \Hashids::decode($hashid);
        if (empty($decodedId)) {
            abort(404); // Trả về lỗi nếu không giải mã được
        }
        
        // Lấy blog bằng ID
        $blog = Blog::with('user')->findOrFail($decodedId[0]);
    
        return view('admin.blogs.show', compact('blog'));
    }
    
    /**
     * Hiển thị danh sách blog cho trang chủ.
     */
    public function showBlogsForHome(Request $request)
    {
        $query = Blog::query();

        // Phân biệt hành động dựa trên button
        $action = $request->get('action');

        if ($action == 'search') {
            // Xử lý tìm kiếm
            if ($request->filled('search')) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            }
        } elseif ($action == 'filter') {
            // Xử lý lọc theo ngày và sắp xếp
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
            } elseif ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            // Sắp xếp
            if ($request->filled('sort')) {
                $query->orderBy('title', $request->sort);
            }
        }

        $blogs = $query->paginate(10)->appends($request->all());

        return view('home.blog', compact('blogs'));
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
    public function edit($hashid)
    {
        $decodedId = \Hashids::decode($hashid);
        if (empty($decodedId)) {
            abort(404);
        }

        $blog = Blog::findOrFail($decodedId[0]);
        $users = User::all();

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
    public function destroy($hashid)
    {
        $decodedId = \Hashids::decode($hashid);
        if (empty($decodedId)) {
            return redirect()->route('blogs.index')->with('error', 'Invalid ID!');
        }

        $result = Blog::deleteBlog($decodedId[0]);

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
    public function favoriteBlogs()
    {
        // Lấy danh sách bài viết yêu thích từ session
        $favoritePosts = session('favorite_posts', []);

        // Kiểm tra nếu danh sách yêu thích có bài viết nào
        if (empty($favoritePosts)) {
            // Nếu không có, trả về view với một collection rỗng
            return view('home.favorite', ['blogs' => collect()]); // trả về một collection rỗng
        }

        // Lấy các bài viết yêu thích từ database
        $blogs = Blog::whereIn('post_id', $favoritePosts)->get();

        // Trả về view với danh sách bài viết yêu thích
        return view('home.favorite', compact('blogs'));
    }

    public function updateFavoritePosts(Request $request)
    {
        // Lấy danh sách bài viết yêu thích từ request
        $favoritePosts = $request->input('favorite_posts', []);

        // Lưu danh sách bài viết yêu thích vào session
        session(['favorite_posts' => $favoritePosts]);

        // Trả về một phản hồi JSON
        return response()->json(['success' => true]);
    }
     /**
     * Tìm kiếm và lọc blog trong trang quản trị.
     */
    public function searchBlogsInAdmin(Request $request)
    {
        $query = Blog::query();

        // Tìm kiếm từ khóa
        if ($request->filled('search')) {
            $query->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$request->search]);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Sắp xếp thứ tự (A-Z, Z-A)
        if ($request->filled('sort')) {
            $query->orderBy('title', $request->sort);
        }

        // Phân trang
        $blogs = $query->paginate(10)->appends($request->all());

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Tìm kiếm và lọc blog trong trang chủ.
     */
    public function searchBlogsInHome(Request $request)
    {
        $query = Blog::query();

        // Tìm kiếm từ khóa
        if ($request->filled('search')) {
            $query->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$request->search]);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        // Sắp xếp
        if ($request->filled('sort')) {
            $query->orderBy('title', $request->sort);
        }

        // Phân trang
        $blogs = $query->paginate(10)->appends($request->all());

        return view('home.blog', compact('blogs'));
    }   

}

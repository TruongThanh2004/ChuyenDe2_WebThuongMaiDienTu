<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $primaryKey = 'post_id';

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'image',
    ];

    /**
     * Liên kết với model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Tạo blog mới và lưu ảnh.
     */
    public static function createBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'user_id' => 'required|integer|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/blog'), $imageName);
            $data['image'] = $imageName;
        }

        return self::create($data);
    }

    /**
     * Cập nhật blog.
     */
    public function updateBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'nullable|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            if ($this->image) {
                Storage::delete('public/images/blog/' . $this->image);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/blog'), $imageName);
            $data['image'] = $imageName;
        }

        return $this->update($data);
    }


    /**
     * Xóa blog.
     */
    public static function deleteBlog($id)
    {
        $blog = self::find($id);
        if ($blog) {
            if ($blog->image) {
                Storage::delete('public/images/blog/' . $blog->image);
            }
            $blog->delete();
            return true;
        }

        return false;
    }

    /**
     * Lấy blog và user.
     */
    public static function getBlogWithUser($id)
    {
        $blog = self::findOrFail($id);
        $users = User::all();

        return compact('blog', 'users');
    }

    /**
     * Lấy danh sách blog cho trang chủ.
     */
    public static function getBlogsForHome()
    {
        $blogs = self::paginate(10);
        return compact('blogs');
    }
    /**
     * Tìm kiếm và lọc blogs.
     */
    public static function searchBlogs(Request $request)
    {
        $query = self::query();

        // Tìm kiếm Full-Text
        if ($search = $request->input('search')) {
            $query->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$search]);
        }

        // Phân trang
        return $query->paginate(10)->appends($request->all());
    }

}

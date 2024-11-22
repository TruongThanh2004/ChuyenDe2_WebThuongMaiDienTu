<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity',
        'category_id',
        'color_id',
        'image1',
        'image2',
        'image3',
        'rating'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
    
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'color_id');
    }
        public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id', 'product_id');
    }
       /**
     * Tạo sản phẩm mới và lưu ảnh.
     */
    public static function createProduct(Request $request)
    {
        // Validate dữ liệu (có thể đưa vào trong Request Class)
        $request->validate([
            'product_name' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/|min:3|max:100',
            'description' => 'required|string|min:10|max:500',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|integer|exists:categories,category_id',
            'color_id' => 'required|integer|exists:colors,color_id',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rating' => 'nullable|integer|min:0|max:5',
        ], [
            'product_name.required' => 'Tên sản phẩm không được bỏ trống.',
            'product_name.string' => 'Tên sản phẩm không hợp lệ. Vui lòng nhập ký tự chữ hoặc số.',
            'product_name.regex' => 'Tên sản phẩm không hợp lệ. Vui lòng chỉ nhập ký tự chữ, số và khoảng trắng.',
            'product_name.min' => 'Tên sản phẩm phải có ít nhất 3 ký tự.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',
            
            'description.required' => 'Mô tả sản phẩm không được bỏ trống.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'price.numeric' => 'Giá sản phẩm không hợp lệ. Vui lòng nhập số dương.',
            'price.min' => 'Giá sản phẩm phải là số dương.',
        
            'quantity.required' => 'Số lượng sản phẩm không được bỏ trống.',
            'quantity.integer' => 'Số lượng sản phẩm không hợp lệ. Vui lòng nhập số dương.',
            'quantity.min' => 'Số lượng sản phẩm phải là số dương.',
        
            'category_id.required' => 'Danh mục sản phẩm không hợp lệ. Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại, vui lòng thêm danh mục.',
        
            'color_id.required' => 'Màu sắc sản phẩm không hợp lệ. Vui lòng chọn màu sắc.',
            'color_id.exists' => 'Không tìm thấy màu sắc, vui lòng thêm màu sắc.',
        
            'image1.image' => 'Tệp tải lên phải là một ảnh hợp lệ.',
            'image1.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image1.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'image2.image' => 'Tệp tải lên phải là một ảnh hợp lệ.',
            'image2.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image2.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'image3.image' => 'Tệp tải lên phải là một ảnh hợp lệ.',
            'image3.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image3.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá phải là một số từ 0 đến 5.',
            'rating.max' => 'Đánh giá phải là một số từ 0 đến 5.',
        ]);

        $data = $request->except(['image1', 'image2', 'image3']);
        $images = [
            'image1' => $request->file('image1'),
            'image2' => $request->file('image2'),
            'image3' => $request->file('image3')
        ];

        $product = new self();
        // Lưu ảnh vào thư mục
        foreach ($images as $key => $image) {
            if ($image) {
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                    return redirect()->back()->withErrors(["$key" => 'File không đúng định dạng được phép.']);
                }
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);
                $data[$key] = $imageName;
            }
        }

        // Tạo sản phẩm mới
        return self::create($data);
    }

    /**
     * Cập nhật sản phẩm.
     */
    public function updateProduct(Request $request)
    {
        // Validate dữ liệu (có thể đưa vào trong Request Class)
        $request->validate([
            'product_name' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/|min:3|max:100',
            'description' => 'nullable|string|min:10|max:500',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|integer|exists:categories,category_id',
            'color_id' => 'required|integer|exists:colors,color_id',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rating' => 'nullable|integer|min:0|max:5',
        ], [
            'product_name.required' => 'Tên sản phẩm không được bỏ trống.',
            'product_name.string' => 'Tên sản phẩm không hợp lệ. Vui lòng nhập ký tự chữ hoặc số.',
            'product_name.regex' => 'Tên sản phẩm không hợp lệ. Vui lòng chỉ nhập ký tự chữ, số và khoảng trắng.',
            'product_name.min' => 'Tên sản phẩm phải có ít nhất 3 ký tự.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',
            
            'description.required' => 'Mô tả sản phẩm không được bỏ trống.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'price.numeric' => 'Giá sản phẩm không hợp lệ. Vui lòng nhập số dương.',
            'price.min' => 'Giá sản phẩm phải là số dương.',
        
            'quantity.required' => 'Số lượng sản phẩm không được bỏ trống.',
            'quantity.integer' => 'Số lượng sản phẩm không hợp lệ. Vui lòng nhập số dương.',
            'quantity.min' => 'Số lượng sản phẩm phải là số dương.',
        
            'category_id.required' => 'Danh mục sản phẩm không hợp lệ. Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại, vui lòng thêm danh mục.',
        
            'color_id.required' => 'Màu sắc sản phẩm không hợp lệ. Vui lòng chọn màu sắc.',
            'color_id.exists' => 'Không tìm thấy màu sắc, vui lòng thêm màu sắc.',
        
            'image1.image' => 'Tệp tải lên phải là một ảnh hợp lệ.',
            'image1.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image1.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'image2.image' => 'Tệp tải lên phải là một ảnh hợp lệ.',
            'image2.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image2.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'image3.image' => 'Tệp tải lên phải là một ảnh hợp lệ.',
            'image3.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image3.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá phải là một số từ 0 đến 5.',
            'rating.max' => 'Đánh giá phải là một số từ 0 đến 5.',
        ]);

        $data = $request->except(['image1', 'image2', 'image3']);
        $images = [
            'image1' => $request->file('image1'),
            'image2' => $request->file('image2'),
            'image3' => $request->file('image3')
        ];

        // Xử lý ảnh và xóa ảnh cũ nếu có
        foreach ($images as $key => $image) {
            if ($image) {
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                    return redirect()->back()->withErrors(["$key" => 'File không đúng định dạng được phép.']);
                }
                // Xóa ảnh cũ nếu có
                if ($this->$key) {
                    Storage::delete('public/images/products/' . $this->$key);
                }
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);
                $data[$key] = $imageName;
            }
        }

        // Cập nhật sản phẩm
        return $this->update($data);
    }

    /**
     * Xóa sản phẩm.
     */
    public static function deleteProduct($hashid)
    {
        $id = Hashids::decode($hashid);
        if (empty($id)) {
            return false;
        }
    
        $product = self::find($id[0]);
        if ($product) {
            // Xóa ảnh nếu có
            foreach (['image1', 'image2', 'image3'] as $imageField) {
                if ($product->$imageField) {
                    Storage::delete('public/images/products/' . $product->$imageField);
                }
            }

            // Xóa sản phẩm
            $product->delete();
            return true;
        }

        return false;
    }


public static function getProductWithCategoryAndColor($id)
{
    $product = Product::with('comments')->findOrFail($id);

    // Lấy tất cả các bình luận của sản phẩm và sắp xếp bình luận của người dùng lên đầu tiên
    $comments = $product->comments()->orderByRaw("name = ? DESC", [Auth::user()->username ?? ''])->get();

    // Lấy tất cả các danh mục và màu sắc
    $categories = Category::all();
    $colors = Color::all();

    // Trả về tất cả dữ liệu cần thiết cho view
    return compact('product', 'comments', 'categories', 'colors');
}


// Product.php (Model)
public static function getProductsForShop()
{
    if (!\Schema::hasTable('products') || !\Schema::hasTable('categories') || !\Schema::hasTable('colors')) {
        return null; // Trả về null nếu có lỗi
    }

    $categories = Category::all();
    $colors = Color::all();
    $products = self::paginate(10);

    return compact('products', 'categories', 'colors');
}
// Product.php (Model)
public static function getLatestProducts($limit = 8)
{
    return self::latest()->take($limit)->get();
}
// Product.php (Model)
// Product.php (Model)
public static function getProductsByCategory($categoryId)
{
    return self::where('category_id', $categoryId)->get();
}
// Product.php (Model)
public static function getFilteredProducts($selectedCategories)
{
    return self::whereIn('category_id', $selectedCategories)->paginate(10);
}
// Product.php (Model)
public static function getFilteredAndSortedProducts($searchTerm,$selectedCategories, $sort = 'asc')
{
    $query = self::query();
    $query = self::when($selectedCategories, function ($query) use ($selectedCategories) {
        return $query->whereIn('category_id', $selectedCategories);
    });
    // Lọc theo từ khóa tìm kiếm trong tên sản phẩm và mô tả
    
    // Tìm kiếm toàn văn bản (Full Text Search)
    if ($searchTerm) {
        $query->where(function ($query) use ($searchTerm) {
            $query->whereRaw('MATCH(product_name, description) AGAINST (? IN BOOLEAN MODE)', [$searchTerm])
                  ->orWhere('product_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        });
    }
    if ($sort === 'asc') {
        $query->orderBy('price', 'asc');
    } elseif ($sort === 'desc') {
        $query->orderBy('price', 'desc');
    }

    return $query->paginate(10)->withQueryString();
}

public static function searchProducts($searchTerm)
{

    return self::where('product_name', 'like', "%$searchTerm%")
               ->orWhere('description', 'like', "%$searchTerm%");
}
}

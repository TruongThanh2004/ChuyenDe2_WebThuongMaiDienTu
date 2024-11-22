<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name'];

    /**
     * Lấy danh sách tất cả danh mục.
     */
    public static function getAllCategories()
    {
        return self::all();
    }

    /**
     * Tìm kiếm danh mục theo từ khóa.
     */
    public static function searchCategories($searchTerm)
    {
        return self::where('category_name', 'like', "%$searchTerm%")
            ->orWhere('category_id', 'like', "%$searchTerm%")
            ->get();
    }

    /**
     * Lấy danh mục theo ID.
     */
    public static function getCategoryById($id)
    {
        return self::findOrFail($id); // Tìm và ném lỗi nếu không tìm thấy
    }

    /**
     * Tạo mới danh mục.
     */
    public static function createCategory($data)
    {
        return self::create($data);
    }

    /**
     * Cập nhật danh mục.
     */
    public function updateCategory($data)
    {
        return $this->update($data);
    }

    /**
     * Xóa danh mục.
     */
    public static function deleteCategory($id)
    {
        $category = self::find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }

    /**
     * Lấy danh sách danh mục có phân trang.
     */
    public static function getPaginatedCategories($perPage = 10)
    {
        return self::paginate($perPage);
    }

    /**
     * Lọc danh mục theo danh sách ID.
     */
    public static function getFilteredCategories($selectedCategoryIds)
    {
        return self::whereIn('category_id', $selectedCategoryIds)->paginate(10);
    }
}

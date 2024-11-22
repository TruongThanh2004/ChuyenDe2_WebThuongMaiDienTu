<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Category extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'categories';
    public $timestamps = false;
    protected $primaryKey = 'category_id';

    /**
     * Các trường có thể được gán giá trị hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'category_name',
    ];
    

    /**
     * Lấy danh sách danh mục với phân trang và tìm kiếm
     *
     * @param string|null $keyword
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getFilteredCategories($keyword = null, $perPage = 5)
{
    $query = self::query();

    // Kiểm tra nếu có từ khóa tìm kiếm
    if (!empty($keyword)) {
        $query->where(function ($query) use ($keyword) {
            // Tìm kiếm full-text trên trường 'category_name'
            $query->whereRaw('MATCH(category_name) AGAINST (? IN BOOLEAN MODE)', [$keyword])
                  // Fallback tìm kiếm LIKE nếu không có kết quả full-text
                  ->orWhere('category_name', 'LIKE', "%{$keyword}%");
        });
    }

    // Trả về kết quả với phân trang
    return $query->paginate($perPage);
}


    /**
     * Thêm danh mục mới
     *
     * @param array $data
     * @return Category
     */
    public static function createCategory($data)
    {
        return self::create($data);
    }

    /**
     * Cập nhật danh mục
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function updateCategory($id, $data)
    {
        $category = self::findOrFail($id);
        return $category->update($data);
    }

    /**
     * Xóa danh mục
     *
     * @param int $id
     * @return bool|null
     */
    public static function deleteCategory($id)
    {
        $category = self::findOrFail($id);
        return $category->delete();
    }

    /**
     * Kiểm tra nếu không còn danh mục
     *
     * @return bool
     */
    public static function isEmpty()
    {
        return self::count() === 0;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Vinkla\Hashids\Facades\Hashids;

class CategoriesController extends Controller
{
    /**
     * Hiển thị danh sách danh mục.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Lấy danh sách danh mục với tìm kiếm và phân trang
        $categories = Category::getFilteredCategories($request->keyword);

        // Kiểm tra nếu danh sách rỗng
        if ($categories->isEmpty()) {
            return view('admin.category', [
                'category' => $categories,
                'error' => 'Không tìm thấy danh mục bạn cần tìm'
            ]);
        }

        return view('admin.category', ['category' => $categories]);
    }

    /**
     * Hiển thị form tạo danh mục.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create_category');
    }

    /**
     * Lưu danh mục mới.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ], [
            'category_name.required' => 'Vui lòng nhập tên danh mục.',
        ]);

        // Gọi hàm trong model để thêm danh mục
        Category::createCategory([
            'category_name' => $request->input('category_name'),
        ]);

        return redirect()->route('category-list')->with('success', 'Thêm danh mục sản phẩm thành công');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($hashId)
    {
        // Giải mã hash ID thành ID thực
        $categoryIds = Hashids::decode($hashId);
        
        // Kiểm tra nếu ID không hợp lệ
        if (empty($categoryIds)) {
            return redirect()->route('category-list')->with('error', 'ID không hợp lệ.');
        }
        
        // Lấy ID thực từ mảng
        $category_id = $categoryIds[0];
        
        // Lấy thông tin danh mục bằng ID thực
        $category = Category::findOrFail($category_id);
        
        // Trả về view và truyền dữ liệu category
        return view('admin.category.edit_category', compact('category'));
    }
    
    /**
     * Cập nhật danh mục.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ], [
            'category_name.required' => 'Vui lòng nhập tên danh mục.',
        ]);

        // Gọi hàm trong model để cập nhật danh mục
        Category::updateCategory($id, $request->only(['category_name']));

        return redirect()->route('category-list')->with('success', 'Cập nhật danh mục thành công.');
    }

    /**
     * Xóa danh mục.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Gọi hàm trong model để xóa danh mục
        Category::deleteCategory($id);

        // Kiểm tra nếu danh sách danh mục trống
        if (Category::isEmpty()) {
            return redirect()->route('category-list')->with('error', 'Không có danh mục nào để hiển thị.');
        }

        return redirect()->route('category-list')->with('success', 'Xóa danh mục thành công.');
    }
}

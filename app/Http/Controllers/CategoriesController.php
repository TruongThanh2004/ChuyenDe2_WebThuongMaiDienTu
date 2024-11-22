<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Lấy danh mục với phân trang
        $category = Category::paginate(5);

        // Kiểm tra từ khóa tìm kiếm và lọc danh mục
        if (isset($request->keyword) && $request->keyword != '') {
            $category = Category::where('category_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('category_id', 'like', '%' . $request->keyword . '%')
                ->paginate(5);
        }

        // Kiểm tra nếu không có danh mục nào
        if ($category->isEmpty()) {
            return view('admin.category', [
                'category' => $category,
                'error' => 'Không tìm thấy danh mục bạn cần tìm'
            ]);
        }

        return view('admin.category', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255', // yêu cầu nhập tên danh mục
        ], [
            'category_name.required' => 'Vui lòng nhập tên danh mục.', // Thông báo lỗi khi không nhập tên
        ]);
    
        // Nếu validation thành công, tạo danh mục mới
        Category::create([
            'category_name' => $request->input('category_name'),
        ]);
    
        // Redirect về danh sách danh mục với thông báo thành công
        return redirect()->route('category-list')->with('success', 'Thêm danh mục sản phẩm thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Lấy thông tin danh mục để chỉnh sửa
        $category = Category::findOrFail($id);
        return view('admin.category.edit_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Cập nhật thông tin danh mục
        $category = Category::findOrFail($id);
        $category->update($request->all());

        // Redirect về trang danh sách danh mục với thông báo thành công
        return redirect()->route('category-list')->with('success', 'Cập nhật danh mục thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Lấy danh mục cần xóa
        $category = Category::findOrFail($id);
        $category->delete();
    
        // Kiểm tra nếu danh sách danh mục còn lại là rỗng
        if (Category::count() === 0) {
            return redirect()->route('category-list')->with('error', 'Không có danh mục nào để hiển thị.');
        }
    
        // Nếu không, redirect với thông báo xóa thành công
        return redirect()->route('category-list')->with('success', 'Xóa danh mục thành công.');
    }
}

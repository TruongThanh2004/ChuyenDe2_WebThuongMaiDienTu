<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;

class ProductController extends Controller
{
    // Hàm thêm sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
            'color_id' => 'required|integer',
            'image1' => 'nullable|string|max:255',
            'image2' => 'nullable|string|max:255',
            'image3' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);

        Product::create($request->all());

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    // Hàm sửa sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
            'color_id' => 'required|integer',
            'image1' => 'nullable|string|max:255',
            'image2' => 'nullable|string|max:255',
            'image3' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);

        $product->update($request->all());

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    // Hàm xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    // Hàm hiển thị tất cả sản phẩm
    public function index()
    {
        // Kiểm tra xem bảng products có tồn tại không
        if (!\Schema::hasTable('products')) {
            // Trả về view với thông báo nếu bảng không tồn tại
            return view('productDashboard')->with('message', 'Bảng sản phẩm không tồn tại.');
        }

        $products = Product::all(); // Lấy tất cả sản phẩm
        $categories = Category::all(); // Lấy tất cả danh mục
        $colors = Color::all(); // Lấy tất cả màu sắc

        return view('productDashboard', compact('products', 'categories', 'colors'));
    }
}

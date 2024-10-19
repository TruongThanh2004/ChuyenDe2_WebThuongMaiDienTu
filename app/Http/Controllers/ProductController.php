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
        // Validate các trường, bao gồm việc kiểm tra file ảnh
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
            'color_id' => 'required|integer',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);
    
        // Khởi tạo mảng dữ liệu sản phẩm
        $data = $request->except(['image1', 'image2', 'image3']); // Loại trừ ảnh từ $request->all()
    
        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $image1Name = time() . '_' . $image1->getClientOriginalName(); // Tạo tên duy nhất cho hình ảnh
            $image1->move(public_path('images/products'), $image1Name); // Di chuyển tệp đến thư mục
            $data['image1'] =  $image1Name; // Lưu đường dẫn file
        }
    
        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $image2Name = time() . '_' . $image2->getClientOriginalName();
            $image2->move(public_path('images/products'), $image2Name);
            $data['image2'] =   $image2Name;
        }
    
        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $image3Name = time() . '_' . $image3->getClientOriginalName();
            $image3->move(public_path('images/products'), $image3Name);
            $data['image3'] =  $image3Name;
        }
    
        // Tạo sản phẩm mới với dữ liệu đã xử lý
        Product::create($data);
    
        return redirect()->back()->with('success', 'Product added successfully.');
    }
    

    // Hàm sửa sản phẩm
    public function update(Request $request, $id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::findOrFail($id);
        
        // Validate các trường, bao gồm file ảnh
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
            'color_id' => 'required|integer',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);
    
        // Khởi tạo mảng dữ liệu sản phẩm
        $data = $request->except(['image1', 'image2', 'image3']); // Loại trừ ảnh từ $request->all()
    
        // Xử lý upload ảnh nếu có và cập nhật dữ liệu
        if ($request->hasFile('image1')) {
            // Xóa ảnh cũ nếu có
            if ($product->image1) {
                \Storage::delete('public/images/products/' . $product->image1);
            }
            $image1 = $request->file('image1');
            $image1Name = time() . '_' . $image1->getClientOriginalName(); // Tạo tên duy nhất cho hình ảnh
            $image1->move(public_path('images/products'), $image1Name); // Di chuyển tệp đến thư mục
            $data['image1'] = $image1Name; // Lưu đường dẫn file
        }
    
        if ($request->hasFile('image2')) {
            // Xóa ảnh cũ nếu có
            if ($product->image2) {
                \Storage::delete('public/images/products/' . $product->image2);
            }
            $image2 = $request->file('image2');
            $image2Name = time() . '_' . $image2->getClientOriginalName();
            $image2->move(public_path('images/products'), $image2Name);
            $data['image2'] = $image2Name;
        }
    
        if ($request->hasFile('image3')) {
            // Xóa ảnh cũ nếu có
            if ($product->image3) {
                \Storage::delete('public/images/products/' . $product->image3);
            }
            $image3 = $request->file('image3');
            $image3Name = time() . '_' . $image3->getClientOriginalName();
            $image3->move(public_path('images/products'), $image3Name);
            $data['image3'] = $image3Name;
        }
    
        // Cập nhật sản phẩm
        $product->update($data);
    
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }
    
    // Hàm xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::where('product_id', $id)->first();
        if ($product) {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa.');
        }
        return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
    }

    // Hàm hiển thị tất cả sản phẩm
    // public function index()
    // {
    //     // Kiểm tra xem bảng products có tồn tại không
    //     if (!\Schema::hasTable('products')) {
    //         // Trả về view với thông báo nếu bảng không tồn tại
    //         return view('admin.products')->with('message', 'Bảng sản phẩm không tồn tại.');
    //     }

    //     $products = Product::all(); // Lấy tất cả sản phẩm
    //     $categories = Category::all(); // Lấy tất cả danh mục
    //     $colors = Color::all(); // Lấy tất cả màu sắc
    //     $products = Product::paginate(10);

    //     return view('productDashboard', compact('products', 'categories', 'colors'));
    // }
    public function index()
    {
        // Kiểm tra xem bảng products có tồn tại không
        if (!\Schema::hasTable('products')) {
            // Trả về view với thông báo nếu bảng không tồn tại
            return view('admin.products')->with('message', 'Bảng sản phẩm không tồn tại.');
        }

        $products = Product::all(); // Lấy tất cả sản phẩm
        $categories = Category::all(); // Lấy tất cả danh mục
        $colors = Color::all(); // Lấy tất cả màu sắc
        $products = Product::paginate(10);

        return view('admin.products', compact('products', 'categories', 'colors'));
    }
    public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all(); // Lấy tất cả các thể loại
    $colors = Color::all(); // Lấy tất cả các màu sắc

    return view('update', compact('product', 'categories', 'colors'));
}
}

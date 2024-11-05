<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;

class ProductController extends Controller
{
    // Hàm thêm sản phẩm
    public function create() {
        $categories = Category::all(); // Lấy danh sách thể loại
        $colors = Color::all(); // Lấy danh sách màu sắc
        return view('admin.product.createproduct', compact('categories', 'colors'));
    }
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
    
        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công.');
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
    
        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công.');
    }
    
    // Hàm xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::where('product_id', $id)->first();
        if ($product) {
            $product->delete();
            return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được xóa.');
        }
        return redirect()->route('admin.products')->with('error', 'Sản phẩm không tồn tại.');
    }



        public function search(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $searchTerm = $request->input('search');

        // Kiểm tra nếu từ khóa tìm kiếm không rỗng
        if ($searchTerm) {
            // Tìm kiếm sản phẩm theo tên sản phẩm, mô tả hoặc các trường khác
            $products = Product::where('product_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('price', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('category', function($query) use ($searchTerm) {
                    $query->where('category_name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->orWhereHas('color', function($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(10); // Phân trang 10 sản phẩm mỗi trang

            // Nếu không có sản phẩm, trả về view với thông báo
            if ($products->isEmpty()) {
                return view('admin.product.products', compact('products'))->with('message', 'Không tìm thấy sản phẩm nào.');
            }

            // Trả về view cùng với kết quả tìm kiếm
            return view('admin.product.products', compact('products'));
        }

        // Nếu không có từ khóa tìm kiếm, trả về danh sách sản phẩm đầy đủ
        return redirect()->route('admin.products')->with('error', 'Vui lòng nhập từ khóa để tìm kiếm.');
    }



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

        return view('admin.product.products', compact('products', 'categories', 'colors'));
    }
    public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all(); // Lấy tất cả các thể loại
    $colors = Color::all(); // Lấy tất cả các màu sắc

    return view('admin.product.update', compact('product', 'categories', 'colors'));
}
public function show($id)
{
    // Lấy sản phẩm theo ID
    $product = Product::findOrFail($id);

    // Lấy thể loại và màu sắc
    $categories = Category::all();
    $colors = Color::all();

    // Nếu bạn muốn chỉ hiển thị sản phẩm mà không cần chỉnh sửa
    return view('admin.product.showproduct', compact('product', 'categories', 'colors'));
}
public function showProduct($id)
{
    // Lấy sản phẩm theo ID
    $product = Product::findOrFail($id);

    // Lấy thể loại và màu sắc
    $categories = Category::all();
    $colors = Color::all();

    // Nếu bạn muốn chỉ hiển thị sản phẩm mà không cần chỉnh sửa
    return view('home.singleProduct', compact('product', 'categories', 'colors'));
}
public function ShowProductShop()
{
    // Kiểm tra xem bảng products, categories và colors có tồn tại không
    if (!\Schema::hasTable('products') || !\Schema::hasTable('categories') || !\Schema::hasTable('colors')) {
        // Trả về view với thông báo nếu bảng không tồn tại
        return view('home.shop')->with('message', 'Một trong các bảng không tồn tại.');
    }

    $products = Product::paginate(10); // Lấy sản phẩm với phân trang 10 sản phẩm mỗi trang
    $categories = Category::all(); // Lấy tất cả danh mục
    $colors = Color::all(); // Lấy tất cả màu sắc

    return view('home.shop', compact('products', 'categories', 'colors'));
}
    public function shop()
    {
        // Lấy 5 sản phẩm mới nhất
        $products = Product::orderBy('created_at', 'desc')->take(8)->get();

        return view('home.home', compact('products'));
    }
}

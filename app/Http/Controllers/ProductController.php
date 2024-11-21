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
        
            'image1.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image1.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'image2.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image2.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'image3.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image3.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá phải là một số từ 0 đến 5.',
            'rating.max' => 'Đánh giá phải là một số từ 0 đến 5.',
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
            'product_name' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/|min:3|max:100',
            'description' => 'required|nullable|string|min:10|max:500',
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
        
            'image1.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image1.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'image2.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image2.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'image3.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif, svg.',
            'image3.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá phải là một số từ 0 đến 5.',
            'rating.max' => 'Đánh giá phải là một số từ 0 đến 5.',
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




    public function searchShop(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $searchTerm = $request->input('search');
        $categories = Category::all(); // Lấy tất cả thể loại sản phẩm
    
        // Kiểm tra nếu không có từ khóa tìm kiếm
        if (empty($searchTerm)) {
            return redirect()->route('shop')->with('error', 'Vui lòng nhập từ khóa để tìm kiếm.');
        }
    
        // Nếu có từ khóa tìm kiếm, thực hiện tìm kiếm sản phẩm
        $products = Product::where('product_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('price', 'LIKE', '%' . $searchTerm . '%')
            ->orWhereHas('category', function($query) use ($searchTerm) {
                $query->where('category_name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orWhereHas('color', function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->paginate(10);
    
        // Nếu không có sản phẩm, trả về view với thông báo
        if ($products->isEmpty()) {
            return view('home.shop', compact('products', 'categories', 'searchTerm'))
                ->with('message', 'Không tìm thấy sản phẩm nào.');
        }
    
        return view('home.shop', compact('products', 'categories', 'searchTerm'));
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
    if ($products->isEmpty()) {
        return view('home.shop', compact('products', 'categories'))
            ->with('message', 'Không có sản phẩm nào.');
    }


    return view('home.shop', compact('products', 'categories', 'colors'));
}
    public function shop()
    {
        // Lấy 5 sản phẩm mới nhất
        $products = Product::orderBy('created_at', 'desc')->take(8)->get();

        return view('home.home', compact('products'));
    }

    public function SortPrice(Request $request)
    {
        $categories = Category::all(); // Lấy tất cả category từ database
        $sort = $request->input('sort', 'asc'); // Mặc định là tăng dần
    
        $query = Product::query();
    
        if ($sort === 'asc') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('price', 'desc');
        }
    
        $products = $query->paginate(10)->appends(['sort' => $sort]);
    
        return view('home.shop', compact('categories','products', 'sort'));
    }

    // Hàm tìm sản phẩm theo danh mục
    public function searchByCategory($categoryId)
    {
        // Tìm sản phẩm thuộc danh mục chỉ định
        $products = Product::where('category_id', $categoryId)->get();
        
        // Kiểm tra nếu không có sản phẩm nào thuộc danh mục này
        if ($products->isEmpty()) {
            return redirect()->route('home.shop')->with('error', 'Không có sản phẩm nào thuộc danh mục này.');
        }

        // Trả về view với danh sách sản phẩm đã tìm được
        return view('home.shop', compact('products'));
    }
    public function filter(Request $request)
    {
        $selectedCategories = $request->input('categories', []);
        
        // Lọc sản phẩm theo danh mục đã chọn
        $products = Product::whereIn('category_id', $selectedCategories)
            ->paginate(10)
            ->appends(['categories' => $selectedCategories]); // Truyền tham số đã chọn qua URL

        return view('home.shop', compact('products', 'selectedCategories'));
    }
public function filterByCategories(Request $request)
{
    $categories = Category::all();
    $selectedCategories = $request->input('categories', []);
    $sort = $request->input('sort', 'asc'); // Lấy thông tin sắp xếp từ request, mặc định là tăng dần

    // Lọc sản phẩm theo danh mục và sắp xếp giá
    $products = Product::when($selectedCategories, function ($query) use ($selectedCategories) {
        return $query->whereIn('category_id', $selectedCategories);
    });

    // Sắp xếp theo giá
    if ($sort === 'asc') {
        $products = $products->orderBy('price', 'asc');
    } elseif ($sort === 'desc') {
        $products = $products->orderBy('price', 'desc');
    }

    $products = $products->paginate(10)->withQueryString(); // Truyền các tham số qua URL để giữ lại khi phân trang

    return view('home.shop', compact('categories', 'products', 'selectedCategories', 'sort'));
}

}

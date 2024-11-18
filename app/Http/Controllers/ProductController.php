<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hàm thêm sản phẩm
    public function create()
    {
        $categories = Category::all(); // Lấy danh sách thể loại
        $colors = Color::all(); // Lấy danh sách màu sắc
        return view('admin.product.createproduct', compact('categories', 'colors'));
    }
    public function store(Request $request)
    {
        Product::createProduct($request);
        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->updateProduct($request);

        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    // Hàm xóa sản phẩm
    public function destroy($id)
    {
        $productDeleted = Product::deleteProduct($id);
        if ($productDeleted) {
            return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được xóa.');
        }

        return redirect()->route('admin.products')->with('error', 'Sản phẩm không tồn tại.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            // Gọi phương thức tìm kiếm từ model
            $products = Product::searchProducts($searchTerm)->paginate(10);

            if ($products->isEmpty()) {
                return view('admin.product.products', compact('products'))->with('message', 'Không tìm thấy sản phẩm nào.');
            }

            return view('admin.product.products', compact('products'));
        }

        return redirect()->route('admin.products')->with('error', 'Vui lòng nhập từ khóa để tìm kiếm.');
    }

    public function searchShop(Request $request)
    {
        $searchTerm = $request->input('search');
        $categories = Category::all();

        if (empty($searchTerm)) {
            return redirect()->route('shop')->with('error', 'Vui lòng nhập từ khóa để tìm kiếm.');
        }

        $products = Product::searchProducts($searchTerm)->paginate(10);

        if ($products->isEmpty()) {
            return view('home.shop', compact('products', 'categories', 'searchTerm'))->with('message', 'Không tìm thấy sản phẩm nào.');
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
// ProductController.php (Controller)
    public function showProduct($id)
    {
        $data = Product::getProductWithCategoryAndColor($id);

        return view('home.singleProduct', $data);
    }

    public function ShowProductShop()
    {
        $data = Product::getProductsForShop();

        if (!$data) {
            return view('home.shop')->with('message', 'Một trong các bảng không tồn tại.');
        }

        if ($data['products']->isEmpty()) {
            return view('home.shop', $data)->with('message', 'Không có sản phẩm nào.');
        }

        return view('home.shop', $data);
    }
    public function shop()
    {
        $products = Product::getLatestProducts();

        return view('home.home', compact('products'));
    }

    public function SortPrice(Request $request)
    {
        $categories = Category::all();
        $sort = $request->input('sort', 'asc'); // Mặc định là tăng dần

        $products = Product::getSortedProducts($sort);

        return view('home.shop', compact('categories', 'products', 'sort'));
    }

    // Hàm tìm sản phẩm theo danh mục
    public function searchByCategory($categoryId)
    {
        $products = Product::getProductsByCategory($categoryId);

        if ($products->isEmpty()) {
            return redirect()->route('home.shop')->with('error', 'Không có sản phẩm nào thuộc danh mục này.');
        }

        return view('home.shop', compact('products'));
    }
    public function filter(Request $request)
    {
        $selectedCategories = $request->input('categories', []);

        $products = Product::getFilteredProducts($selectedCategories);

        return view('home.shop', compact('products', 'selectedCategories'));
    }
    public function filterByCategories(Request $request)
    {
        $categories = Category::all();
        $selectedCategories = $request->input('categories', []);
        $sort = $request->input('sort', 'asc'); // Mặc định là tăng dần

        $products = Product::getFilteredAndSortedProducts($selectedCategories, $sort);

        return view('home.shop', compact('categories', 'products', 'selectedCategories', 'sort'));
    }

}

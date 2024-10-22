<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
<<<<<<< HEAD
use App\Http\Controllers\CategoriesController;
=======
>>>>>>> parent of f4ad518 (Reapply "Merge branch 'CRUD_User'")

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/singleProduct', function () {
    return view('singleProduct');
});



Route::get('/product-list', function () {
    return view('admin.products')  ;
});


//check login -> admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::controller(UserController::class)->prefix('user-list')->group(function () {
        Route::get('', 'index')->name('user-list'); 
        Route::get('create', 'create')->name('user-list.create');
        Route::post('store', 'store')->name('user-list.store');
        Route::get('show/{id}', 'show')->name('user-list.show');
        Route::get('edit/{id}', 'edit')->name('user-list.edit');
        Route::put('edit/{id}', 'update')->name('user-list.update');
        Route::delete('destroy/{id}', 'destroy')->name('user-list.destroy');
    });


    Route::get('/admin/products', [ProductController::class, 'index1'])->name('admin.products');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/update/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    Route::controller(CategoriesController::class)->prefix('category-list')->group(function () {
        Route::get('', 'index')->name('category-list');
        Route::get('create', 'create')->name('category-list.create');
        Route::post('store', 'store')->name('category-list.store');
        Route::get('show/{id}', 'show')->name('category-list.show');
        Route::get('edit/{id}', 'edit')->name('category-list.edit');
        Route::put('edit/{id}', 'update')->name('category-list.update');
        Route::delete('destroy/{id}', 'destroy')->name('category-list.destroy');
      
    });
});



//Register - Login
Route::get('/register', function () {
    return view('Register');
})->name('register');

Route::post('/save-user',[UserController::class,'save'])->name('saveUser');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/do-login',[UserController::class,'doLogin'])->name('doLogin');

Route::get('/logout',[UserController::class,'logout'])->name('logout');

Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
// Route để hiển thị form thêm sản phẩm
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
// Route để lưu sản phẩm
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('admin/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');



// colors
// Route::prefix('admin/colors')->controller(ColorController::class)->group(function () {
//     Route::get('', 'index')->name('admin_colors.index');
//     Route::get('create', 'create')->name('admin_colors.create');
//     Route::post('store', 'AddNewcolors')->name('admin_colors.AddNewcolors');
//     Route::get('edit/{id}', 'edit')->name('admin_colors.edit');
//     Route::put('update/{id}', 'update')->name('admin_colors.update');
//     Route::delete('destroy/{id}', 'destroy')->name('admin_colors.destroy');
// });
Route::prefix('admin/colors')->group(function () {
    Route::get('/', [ColorController::class, 'index'])->name('admin_colors.index');  // Danh sách màu
    Route::get('create', [ColorController::class, 'create'])->name('admin_colors.create');  // Form tạo mới
    Route::post('store', [ColorController::class, 'AddNewcolors'])->name('admin_colors.store');  // Thêm mới
    Route::get('edit/{id}', [ColorController::class, 'edit'])->name('admin_colors.edit');  // Form chỉnh sửa
    Route::put('update/{id}', [ColorController::class, 'update'])->name('admin_colors.update');  // Cập nhật
    Route::delete('destroy/{id}', [ColorController::class, 'destroy'])->name('admin_colors.destroy');  // Xóa

  
});

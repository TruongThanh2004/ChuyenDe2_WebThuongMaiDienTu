<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckRole;
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
    
        return view('home.home');
    })->name('home');
   
    // Route::get('/', [ProductController::class, 'index2'])->name('home');

    Route::get('/shop', function () {
        return view('home.shop');
    });
    
    Route::get('/blog', function () {
        return view('home.blog');
    });
    
    Route::get('/about', function () {
        return view('home.about');
    });
    
    Route::get('/contact', function () {
        return view('home.contact');
    });
    
    Route::get('/cart', function () {
        return view('cart');
    });
    
    Route::get('/singleProduct', function () {
        return view('home.singleProduct');
    });
    
    
    
    Route::get('/product-list', function () {
        return view('admin.products')  ;
    });
    
    
    



Route::get('/shop', function () {
    return view('home.shop');
});

Route::get('/blog', function () {
    return view('home.blog');
});

Route::get('/about', function () {
    return view('home.about');
});

Route::get('/contact', function () {
    return view('home.contact');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/singleProduct', function () {
    return view('home.singleProduct');
});



Route::get('/product-list', function () {
    return view('admin.products')  ;
});



Route::middleware(['auth'])->group(function(){
   Route::controller(ProfileController::class)->prefix('profile')->group(function(){
    Route::get('','index')->name('profile');
    Route::put('edit/{id}','update')->name('profile.update');
   });



});


//check login -> admin
Route::middleware(['auth','checkrole'])->group(function () {
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
        Route::get('', 'index')->name(name: 'category-list');
        Route::get('create', 'create')->name('category-list.create');
        Route::post('store', 'store')->name('category-list.store');
        Route::get('show/{id}', 'show')->name('category-list.show');
        Route::get('edit/{id}', 'edit')->name('category-list.edit');
        Route::put('edit/{id}', 'update')->name('category-list.update');
        Route::delete('destroy/{id}', 'destroy')->name('category-list.destroy');
        
    });
    
    // Route::controller(ProductController::class)->prefix('products-list')->group(function () {
        //     Route::get('', 'index')->name('products.index');
        //     Route::get('create', 'create')->name('products.create');
        //     Route::post('store', 'store')->name('products.store');
        //     Route::get('edit/{id}', 'edit')->name('products.edit');
        //     Route::put('update/{id}', 'update')->name('products.update');
        //     Route::delete('delete/{id}', 'destroy')->name('products.destroy');
        //     Route::get('search', 'search')->name('products.search');
        // });
    
        
        Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
        // Route để hiển thị form thêm sản phẩm
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
        // Route để lưu sản phẩm
        Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('admin/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');
        Route::get('/products/{id}/show', [ProductController::class, 'show'])->name('products.show');
        
    });

Route::get('/shop', [ProductController::class, 'ShowProductHome']);


//Register - Login

Route::get('/register',[AccountController::class,'register'])->name('register');

Route::post('/save-user',[AccountController::class,'save'])->name('saveUser');

Route::get('/login',[AccountController::class,'login'])->name('login');



Route::post('/do-login',[AccountController::class,'doLogin'])->name('doLogin');

Route::get('/logout',[AccountController::class,'logout'])->name('logout');


Route::get('/forgot-password',[AccountController::class,'forgot_password'])->name('forgot_password');
Route::post('/forgot-password',[AccountController::class,'check_forgot_password'])->name('check_forgot_password');

Route::get('/reset-password/{token}',[AccountController::class,'reset_password'])->name('reset-password');
Route::post('/reset-password/{token}',[AccountController::class,'check_reset_password']);   









// colors
Route::prefix('admin/colors')->group(function () {
    Route::get('/', [ColorController::class, 'index'])->name('admin_colors.index');  // Danh sách màu
    Route::get('create', [ColorController::class, 'create'])->name('admin_colors.create');  // Form tạo mới
    Route::post('store', [ColorController::class, 'AddNewcolors'])->name('admin_colors.store');  // Thêm mới
    Route::get('edit/{id}', [ColorController::class, 'edit'])->name('admin_colors.edit');  // Form chỉnh sửa
    Route::put('update/{id}', [ColorController::class, 'update'])->name('admin_colors.update');  // Cập nhật
    Route::delete('destroy/{id}', [ColorController::class, 'destroy'])->name('admin_colors.destroy');  // Xóa
    Route::get('timkiemcolors', [ColorController::class, 'timkiemcolors'])->name('admin_colors.timkiemcolors');
});

// Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
// Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');

// Route::POST('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
// Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
// Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
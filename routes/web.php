<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;

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
});

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



Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index'); // Hiển thị danh sách blog
Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create'); // Hiển thị form thêm blog
Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store'); // Xử lý thêm blog
Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit'); // Hiển thị form sửa blog
Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update'); // Xử lý sửa blog
Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy'); // Xóa blog
Route::get('/blogs', [BlogController::class, 'phanTrang'])->name('blogs.index');
Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

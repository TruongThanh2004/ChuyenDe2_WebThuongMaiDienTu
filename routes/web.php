<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('Register');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard')  ;
});
Route::get('/product-list', function () {
    return view('admin.products')  ;
});








//ADMIN-USER
Route::controller(UserController::class)->prefix('user-list')->group(function () {
    Route::get('', 'index')->name('user-list');
    Route::get('create', 'create')->name('user-list.create');
    Route::post('store', 'store')->name('user-list.store');
    Route::get('show/{id}', 'show')->name('user-list.show');
    Route::get('edit/{id}', 'edit')->name('user-list.edit');
    Route::put('edit/{id}', 'update')->name('user-list.update');
    Route::delete('destroy/{id}', 'destroy')->name('user-list.destroy');
  
});



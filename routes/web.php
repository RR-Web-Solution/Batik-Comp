<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [AdminController::class, 'index']);
Route::match(['GET', 'POST'], '/admin/action', [AdminController::class, 'action'])->name('login.action');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/user', [AdminController::class, 'user'])->name('user');
    Route::post('/user', [AdminController::class, 'createUser'])->name('user.create');
    Route::put('/user/{id}', [AdminController::class, 'editUser'])->name('user.edit');
    Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('user.delete');
    Route::get('/product', [AdminController::class, 'product'])->name('product');
    Route::post('/product', [AdminController::class, 'createProduct'])->name('product.create');
    Route::put('/product/{id}', [AdminController::class, 'editProduct'])->name('product.edit');
    Route::delete('/product/{id}', [AdminController::class, 'deleteProduct'])->name('product.delete');
    Route::get('/order', [AdminController::class, 'orders'])->name('order');
    Route::get('/order/{id}', [AdminController::class, 'orderShow'])->name('order.show');
    Route::patch('/order/{id}', [AdminController::class, 'updateOrderStatus'])->name('order.update');
    Route::get('/category', [AdminController::class, 'categories'])->name('category');
    Route::post('/category', [AdminController::class, 'createCategory'])->name('category.create');
    Route::put('/category/{id}', [AdminController::class, 'editCategory'])->name('category.edit');
    Route::delete('/category/{id}', [AdminController::class, 'deleteCategory'])->name('category.delete');
    Route::get('/setting', [AdminController::class, 'settings'])->name('setting');
    Route::put('/setting/{id}', [AdminController::class, 'updateSettings'])->name('setting.update');
    Route::get('/testimonial', [AdminController::class, 'testimonials'])->name('testimonial');
    Route::post('/testimonial', [AdminController::class, 'createTestimonial'])->name('testimonial.create');
    Route::put('/testimonial/{id}', [AdminController::class, 'editTestimonial'])->name('testimonial.edit');
    Route::delete('/testimonial/{id}', [AdminController::class, 'deleteTestimonial'])->name('testimonial.delete');
});

Route::prefix('{locale}')->middleware(SetLocale::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/produk/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/pesanan', [OrderController::class, 'store'])->name('order.store');
    Route::get('/pesanan/sukses/{orderNumber}', [OrderController::class, 'success'])->name('order.success');
    Route::get('/lacak', [OrderController::class, 'track'])->name('order.track');
    Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
});

Route::get('/', fn () => redirect(route('home', ['locale' => 'id'])));

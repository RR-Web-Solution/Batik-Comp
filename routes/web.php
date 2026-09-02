<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [AuthController::class, 'index']);
Route::match(['GET', 'POST'], '/admin/action', [AuthController::class, 'action'])->name('login.action');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', [AdminUserController::class, 'index'])->name('user');
    Route::post('/user', [AdminUserController::class, 'store'])->name('user.create');
    Route::put('/user/{id}', [AdminUserController::class, 'update'])->name('user.edit');
    Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('user.delete');

    Route::get('/product', [AdminProductController::class, 'index'])->name('product');
    Route::post('/product', [AdminProductController::class, 'store'])->name('product.create');
    Route::put('/product/{id}', [AdminProductController::class, 'update'])->name('product.edit');
    Route::delete('/product/{id}', [AdminProductController::class, 'destroy'])->name('product.delete');

    Route::get('/order', [AdminOrderController::class, 'index'])->name('order');
    Route::get('/order/{id}', [AdminOrderController::class, 'show'])->name('order.show');
    Route::patch('/order/{id}', [AdminOrderController::class, 'updateStatus'])->name('order.update');

    Route::get('/category', [AdminCategoryController::class, 'index'])->name('category');
    Route::post('/category', [AdminCategoryController::class, 'store'])->name('category.create');
    Route::put('/category/{id}', [AdminCategoryController::class, 'update'])->name('category.edit');
    Route::delete('/category/{id}', [AdminCategoryController::class, 'destroy'])->name('category.delete');

    Route::get('/setting', [AdminSettingController::class, 'index'])->name('setting');
    Route::put('/setting/{id}', [AdminSettingController::class, 'update'])->name('setting.update');

    Route::get('/testimonial', [AdminTestimonialController::class, 'index'])->name('testimonial');
    Route::post('/testimonial', [AdminTestimonialController::class, 'store'])->name('testimonial.create');
    Route::put('/testimonial/{id}', [AdminTestimonialController::class, 'update'])->name('testimonial.edit');
    Route::delete('/testimonial/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonial.delete');
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

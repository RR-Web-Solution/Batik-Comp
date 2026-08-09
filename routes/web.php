<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::post('/admin/action', [App\Http\Controllers\AdminController::class, 'action'])->name('login.action');
Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
Route::get('/user', [App\Http\Controllers\AdminController::class, 'user'])->name('user');
Route::get('/product', [App\Http\Controllers\AdminController::class, 'product'])->name('product');
Route::post('/user', [App\Http\Controllers\AdminController::class, 'createUser'])->name('user.create');
Route::put('/user/{id}', [App\Http\Controllers\AdminController::class, 'editUser'])->name('user.edit');
Route::delete('/user/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('user.delete');
Route::post('/product', [App\Http\Controllers\AdminController::class, 'createProduct'])->name('product.create');
Route::put('/product/{id}', [App\Http\Controllers\AdminController::class, 'editProduct'])->name('product.edit');
Route::delete('/product/{id}', [App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('product.delete');

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('sort_order')->get();
        $setting = Setting::first() ?? new Setting;

        return view('product.index', compact('products', 'setting'));
    }
}

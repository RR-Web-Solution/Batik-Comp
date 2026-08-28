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

    public function show($locale, $id)
    {
        $product = Product::with('category')->findOrFail($id);
        $setting = Setting::first() ?? new Setting;
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('product.show', compact('product', 'setting', 'relatedProducts'));
    }
}

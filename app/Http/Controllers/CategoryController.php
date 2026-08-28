<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;

class CategoryController extends Controller
{
    public function show($locale, string $slug)
    {
        $category = Category::where('slug', $slug)
            ->with('products')
            ->firstOrFail();

        $products = $category->products;
        $setting = Setting::first() ?? new Setting;

        return view('category.show', compact('category', 'products', 'setting'));
    }
}

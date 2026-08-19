<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting;
        $categories = Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();
        $featuredProducts = Product::where('is_featured', true)->orderBy('sort_order')->get();

        return view('home.index', compact('setting', 'categories', 'featuredProducts'));
    }
}

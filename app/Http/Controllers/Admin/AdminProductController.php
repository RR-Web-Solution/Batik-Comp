<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $product = Product::with('category')->orderBy('sort_order')->get();
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.product', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $price = $request->input('price');
        if (! is_numeric($price)) {
            return back()->with('error', 'Harga harus berupa angka');
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->price = $price;
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id') ?: null;
        $product->is_featured = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! $this->validateImage($image)) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $product->image = $this->storeUploadedImage($image);
        }

        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $price = $request->input('price');
        if (! is_numeric($price)) {
            return back()->with('error', 'Harga harus berupa angka');
        }

        $product->name = $request->input('name');
        $product->price = $price;
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id') ?: null;
        $product->is_featured = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! $this->validateImage($image)) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $this->deleteUploadedImage($product->image);
            $product->image = $this->storeUploadedImage($image);
        }

        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->deleteUploadedImage($product->image);
        $product->delete();

        return redirect()->route('product')->with('success', 'Produk berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $category = Category::withCount('products')->orderBy('sort_order')->get();

        return view('admin.category', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $category = new Category;
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->sort_order = $request->input('sort_order', 0);
        $category->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! $this->validateImage($image)) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $category->image = $this->storeUploadedImage($image, 'category_');
        }

        $category->save();

        return redirect()->route('category')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->sort_order = $request->input('sort_order', 0);
        $category->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! $this->validateImage($image)) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $this->deleteUploadedImage($category->image);
            $category->image = $this->storeUploadedImage($image, 'category_');
        }

        $category->save();

        return redirect()->route('category')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->deleteUploadedImage($category->image);
        $category->delete();

        return redirect()->route('category')->with('success', 'Kategori berhasil dihapus.');
    }
}

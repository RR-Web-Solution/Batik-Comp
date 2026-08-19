<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function action(Request $request)
    {
        // var_dump($request->all());
        // die();
        $credential = $request->only('email', 'password');

        // Auth:attempt: Cek email dan password betul
        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            $user = Auth::user();
            session(['user_id' => $user->id, 'user_name' => $user->name]);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin');
    }

    public function user()
    {
        $user = User::all();

        return view('admin.user', compact('user'));
    }

    public function product()
    {
        $product = Product::all();

        return view('admin.product', compact('product'));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'User berhasil dihapus.');
    }

    public function createProduct(Request $request)
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $product->image = $this->storeUploadedImage($image);
        }

        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan');
    }

    public function editProduct(Request $request, $id)
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $this->deleteProductImage($product->image);
            $product->image = $this->storeUploadedImage($image);
        }

        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil diupdate');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->deleteProductImage($product->image);
        $product->delete();

        return redirect()->route('product')->with('success', 'Produk berhasil dihapus');
    }

    private function storeUploadedImage(UploadedFile $image): string
    {
        $filename = 'product_'.time().'_'.bin2hex(random_bytes(4)).'.'.$image->getClientOriginalExtension();
        File::ensureDirectoryExists(public_path('uploads'));
        $image->move(public_path('uploads'), $filename);

        return $filename;
    }

    private function deleteProductImage(?string $image): void
    {
        if ($image && file_exists(public_path('uploads/'.$image))) {
            unlink(public_path('uploads/'.$image));
        }
    }
}

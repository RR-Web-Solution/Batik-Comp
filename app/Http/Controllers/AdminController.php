<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

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

        //Auth:attempt: Cek email dan password betul
        if(Auth::attempt($credential)) {
            $request->session()->regenerate();
            $user = Auth::user();
            session(['user_id' => $user->id, 'user_name' => $user->name]);
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin');
    }

    public function user() {
        $user = User::all();
        return view('admin.user', compact('user'));
    }

    public function product() {
        $product = Product::all();
        return view('admin.product', compact('product'));
    }

    public function createUser(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'User berhasil dihapus.');
    }

    public function createProduct(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduct(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct($id) {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product')->with('success', 'Produk berhasil dihapus.');
    }
}

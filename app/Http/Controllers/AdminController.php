<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('admin.index');
    }

    public function dashboard()
    {
        $stats = [
            'categories' => Category::count(),
            'products' => Product::count(),
            'orders' => Order::valid()->count(),
            'ordersToday' => Order::whereDate('created_at', today())->count(),
            'revenue' => Order::valid()->sum('total'),
        ];

        $recentOrders = Order::with('product')->latest()->limit(10)->get();

        $monthlyRevenue = Order::valid()
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue'),
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $ordersPerCategory = Order::valid()
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('COUNT(*) as count'))
            ->groupBy('categories.name')
            ->pluck('count', 'category')
            ->toArray();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'monthlyRevenue', 'ordersPerCategory'));
    }

    public function action(Request $request)
    {
        if ($request->isMethod('get')) {
            return Auth::check() ? redirect('/dashboard') : redirect('/admin');
        }

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
        $product = Product::with('category')->orderBy('sort_order')->get();
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.product', compact('product', 'categories'));
    }

    public function orders(Request $request)
    {
        $orders = Order::with('product')
            ->status($request->query('status'))
            ->search($request->query('q'))
            ->latest()
            ->get();

        return view('admin.order', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
            'currentStatus' => $request->query('status'),
            'currentSearch' => $request->query('q'),
        ]);
    }

    public function orderShow($id)
    {
        $order = Order::with('product')->findOrFail($id);

        return view('admin.order-show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:'.implode(',', Order::STATUSES)],
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return back()->with('success', "Status {$order->order_number} diubah menjadi {$order->status}.");
    }

    public function categories()
    {
        $category = Category::withCount('products')->orderBy('sort_order')->get();

        return view('admin.category', compact('category'));
    }

    public function createCategory(Request $request)
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
            if (! in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $category->image = $this->storeUploadedImage($image, 'category_');
        }

        $category->save();

        return redirect()->route('category')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function editCategory(Request $request, $id)
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
            if (! in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $this->deleteUploadedImage($category->image);
            $category->image = $this->storeUploadedImage($image, 'category_');
        }

        $category->save();

        return redirect()->route('category')->with('success', 'Kategori berhasil diupdate.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->deleteUploadedImage($category->image);
        $category->delete();

        return redirect()->route('category')->with('success', 'Kategori berhasil dihapus.');
    }

    public function settings()
    {
        $setting = Setting::first() ?? new Setting;

        return view('admin.setting', compact('setting'));
    }

    public function updateSettings(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'opening_hours' => ['nullable', 'string'],
            'about_text' => ['nullable', 'string'],
            'instagram_usn' => ['nullable', 'string'],
            'facebook_usn' => ['nullable', 'string'],
        ]);

        $setting->update($data);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
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
        $product->category_id = $request->input('category_id') ?: null;
        $product->is_featured = $request->boolean('is_featured');

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
        $product->category_id = $request->input('category_id') ?: null;
        $product->is_featured = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (! in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return back()->with('error', 'Format gambar tidak didukung (hanya JPG, PNG, WebP)');
            }
            $this->deleteUploadedImage($product->image);
            $product->image = $this->storeUploadedImage($image);
        }

        $product->save();

        return redirect()->route('product')->with('success', 'Produk berhasil diupdate');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->deleteUploadedImage($product->image);
        $product->delete();

        return redirect()->route('product')->with('success', 'Produk berhasil dihapus');
    }

    public function testimonials()
    {
        $testimonial = Testimonial::orderBy('sort_order')->get();

        return view('admin.testimonial', compact('testimonial'));
    }

    public function createTestimonial(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_title' => 'nullable|string|max:100',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'customer_name' => $request->input('customer_name'),
            'customer_title' => $request->input('customer_title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return redirect()->route('testimonial')->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function editTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_title' => 'nullable|string|max:100',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial->update([
            'customer_name' => $request->input('customer_name'),
            'customer_title' => $request->input('customer_title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return redirect()->route('testimonial')->with('success', 'Testimonial berhasil diupdate.');
    }

    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('testimonial')->with('success', 'Testimonial berhasil dihapus.');
    }

    private function storeUploadedImage(UploadedFile $image, string $prefix = 'product_'): string
    {
        $filename = $prefix.time().'_'.bin2hex(random_bytes(4)).'.'.$image->getClientOriginalExtension();
        File::ensureDirectoryExists(public_path('uploads'));
        $image->move(public_path('uploads'), $filename);

        return $filename;
    }

    private function deleteUploadedImage(?string $image): void
    {
        if ($image && file_exists(public_path('uploads/'.$image))) {
            unlink(public_path('uploads/'.$image));
        }
    }
}

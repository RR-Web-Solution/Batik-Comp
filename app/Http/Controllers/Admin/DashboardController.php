<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
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
}

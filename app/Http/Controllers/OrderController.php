<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
            'notes' => ['nullable', 'string', 'max:500'],
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:20'],
        ]);

        $existing = Order::where('product_id', $validated['product_id'])
            ->where('customer_name', $validated['customer_name'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();

        if ($existing) {
            return redirect()->route('order.success', [
                'locale' => app()->getLocale(),
                'orderNumber' => $existing->order_number,
            ]);
        }

        $order = Order::create([...$validated, 'status' => 'menunggu']);
        $order->total = $order->calculateTotal();
        $order->save();

        return redirect()->route('order.success', [
            'locale' => app()->getLocale(),
            'orderNumber' => $order->order_number,
        ]);
    }

    public function track(Request $request)
    {
        $order = null;

        if ($request->filled('order_number')) {
            $order = Order::with('product')
                ->where('order_number', $request->order_number)
                ->first();
        }

        return view('order.track', [
            'order' => $order,
            'searched' => $request->filled('order_number'),
            'setting' => Setting::first() ?? new Setting,
        ]);
    }

    public function success($locale, string $orderNumber)
    {
        return view('order.success', [
            'order' => Order::where('order_number', $orderNumber)->firstOrFail(),
            'setting' => Setting::first() ?? new Setting,
        ]);
    }
}

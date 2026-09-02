<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
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

    public function show($id)
    {
        $order = Order::with('product')->findOrFail($id);

        return view('admin.order-show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:'.implode(',', Order::STATUSES)],
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return back()->with('success', "Status {$order->order_number} diubah menjadi {$order->status}.");
    }
}

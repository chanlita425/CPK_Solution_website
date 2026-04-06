<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        // Search filter - by order code or customer name/phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pages.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.pages.orders.show', compact('order'));
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Order cannot be confirmed.');
        }

        try {
            $order->confirm();
            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order confirmed successfully! Stock has been updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to confirm order: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Order cannot be cancelled.');
        }

        $order->cancel();

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order cancelled successfully!');
    }
}

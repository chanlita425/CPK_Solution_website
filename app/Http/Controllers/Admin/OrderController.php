<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        // Search filter - by order code only
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('order_code', 'like', "%{$search}%");
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
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Order cannot be confirmed.'], 400);
            }
            return redirect()->back()->with('error', 'Order cannot be confirmed.');
        }

        try {
            $order->confirm();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Order confirmed successfully! Stock has been updated.']);
            }
            return redirect()->route('admin.orders.show', $order->id)
                ->with('toast', ['message' => 'Order confirmed successfully! Stock has been updated.', 'type' => 'success']);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to confirm order: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to confirm order: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Order cannot be cancelled.'], 400);
            }
            return redirect()->back()->with('error', 'Order cannot be cancelled.');
        }

        $order->cancel();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Order cancelled successfully!']);
        }
        return redirect()->route('admin.orders.show', $order->id)
            ->with('toast', ['message' => 'Order cancelled successfully!', 'type' => 'success']);
    }
}

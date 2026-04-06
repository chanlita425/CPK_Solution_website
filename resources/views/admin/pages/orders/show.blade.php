{{-- resources/views/admin/orders/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Order #' . $order->order_code)
@section('header', 'Order Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-yellow-600">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>

        @if ($order->status == 'pending')
            <div class="flex gap-3">
                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition"
                        onclick="return confirm('Confirm this order? Stock will be reduced.')">
                        <i class="fas fa-check-circle mr-2"></i> Confirm Order
                    </button>
                </form>
                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition"
                        onclick="return confirm('Cancel this order?')">
                        <i class="fas fa-times-circle mr-2"></i> Cancel Order
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-semibold text-gray-800">Order Items</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        <div class="text-xs text-gray-500">SKU: {{ $item->product->SKU ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        ${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <!-- Order Status -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Order Status</h3>
                <div class="flex items-center gap-3">
                    <span
                        class="px-3 py-1 rounded-full text-sm font-medium
                    @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'confirmed') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <span class="text-sm text-gray-500">Updated: {{ $order->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Order Code:</span>
                        <span class="font-medium">{{ $order->order_code }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Date:</span>
                        <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Discount:</span>
                                <span>-${{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span>${{ number_format($order->shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax:</span>
                            <span>${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t mt-2">
                            <span>Total:</span>
                            <span class="text-yellow-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Customer Information</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Name:</span>
                        <span>{{ $order->customer_name ?? 'Guest' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Phone:</span>
                        <span>{{ $order->customer_phone ?? '-' }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="text-gray-600">Address:</span>
                        <p class="mt-1 text-gray-800">{{ $order->customer_address ?? '-' }}</p>
                    </div>
                    @if ($order->note)
                        <div class="text-sm pt-2 border-t">
                            <span class="text-gray-600">Note:</span>
                            <p class="mt-1 text-gray-800">{{ $order->note }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

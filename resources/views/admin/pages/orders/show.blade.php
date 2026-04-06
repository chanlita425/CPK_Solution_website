@extends('admin.layouts.app')

@section('title', 'Order #' . $order->order_code)
@section('header', 'Order Details')
@section('subheader', 'View and manage order #' . $order->order_code)

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('admin.orders.index') }}"
                class="text-gray-600 hover:text-[#D7B259] transition inline-flex items-center gap-2">
                <i class="fas fa-arrow-left text-sm"></i> Back to Orders
            </a>

            @if ($order->status == 'pending')
                <div class="flex gap-3">
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2"
                            onclick="return confirm('Confirm this order? Stock will be reduced.')">
                            <i class="fas fa-check-circle"></i> Confirm Order
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2"
                            onclick="return confirm('Cancel this order?')">
                            <i class="fas fa-times-circle"></i> Cancel Order
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="font-semibold text-gray-800">
                            <i class="fas fa-boxes text-[#D7B259] mr-2"></i> Order Items
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                            <div class="text-xs text-gray-500">SKU: {{ $item->product->SKU ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">${{ number_format($item->price, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 text-right">
                                            ${{ number_format($item->line_total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        <i class="fas fa-chart-line text-[#D7B259] mr-2"></i> Order Status
                    </h3>
                    <div class="flex items-center justify-between">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium
                        @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'confirmed') bg-emerald-100 text-emerald-800
                        @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <span class="text-sm text-gray-500">
                            Updated: {{ $order->updated_at->format('M d, Y H:i') }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        <i class="fas fa-calculator text-[#D7B259] mr-2"></i> Order Summary
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Order Code:</span>
                            <span class="font-mono font-medium">{{ $order->order_code }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Date Placed:</span>
                            <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if ($order->discount > 0)
                                <div class="flex justify-between text-sm text-emerald-600">
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
                                <span class="text-[#D7B259]">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order->coupon_code)
                    <div class="bg-amber-50 rounded-2xl border border-amber-200 p-6">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-ticket-alt text-amber-600 text-xl"></i>
                            <div>
                                <p class="text-sm font-medium text-amber-800">Coupon Applied</p>
                                <p class="text-amber-700 font-mono">{{ $order->coupon_code }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

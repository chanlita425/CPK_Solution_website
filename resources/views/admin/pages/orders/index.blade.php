@extends('admin.layouts.app')

@section('title', 'Orders')
@section('header', 'Orders')
@section('subheader', 'Manage customer orders')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <p class="text-gray-600 text-sm">Manage and track customer orders</p>
            <a href="{{ route('admin.orders.index') }}" class="btn-primary">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>

        <!-- Filter Toolbar -->
        @php
            $orderFilters = [['type' => 'status', 'name' => 'status']];
        @endphp

        @include('admin.components.filter-toolbar', [
            'searchPlaceholder' => 'Search by order code or customer name...',
            'searchValue' => request('search'),
            'filters' => $orderFilters,
            'showReset' => true,
        ])

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg p-4">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Orders Table -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                                Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono font-medium text-gray-900">{{ $order->order_code }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->customer_name ?? 'Guest' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $order->customer_phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $order->items->count() }} items</td>
                                <td class="px-6 py-4 text-gray-600">${{ number_format($order->subtotal, 2) }}</td>
                                <td class="px-6 py-4 font-semibold text-[#D7B259]">${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'confirmed') bg-emerald-100 text-emerald-800
                                @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <div class="text-xs">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="text-[#D7B259] hover:text-amber-700 p-1 transition inline-flex items-center gap-1">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500 mb-2">No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        // The filter toolbar handles the filtering automatically
        // No additional JavaScript needed
    </script>
@endsection

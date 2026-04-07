{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Overview of your store performance')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h2>
                    <p class="text-gray-300 text-sm">Here's what's happening with your store today.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-chart-line text-4xl text-[#D7B259]/30"></i>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Categories -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Categories</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalCategories ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-folder text-amber-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.categories.index') }}" class="text-[#D7B259] text-sm hover:underline">Manage
                        Categories →</a>
                </div>
            </div>

            <!-- Total Brands -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Brands</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalBrands ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trademark text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.brands.index') }}" class="text-[#D7B259] text-sm hover:underline">Manage Brands
                        →</a>
                </div>
            </div>

            <!-- Total Products -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Products</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalProducts ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.products.index') }}" class="text-[#D7B259] text-sm hover:underline">Manage
                        Products →</a>
                </div>
            </div>

            <!-- Active Coupons -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Coupons</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($activeCoupons ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.coupons.index') }}" class="text-[#D7B259] text-sm hover:underline">Manage
                        Coupons →</a>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Orders Summary -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Orders Summary</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalOrders ?? 0) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Orders</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-bold text-amber-600">{{ number_format($pendingOrders ?? 0) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Pending</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-bold text-emerald-600">{{ number_format($confirmedOrders ?? 0) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Confirmed</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.products.create') }}"
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-amber-50 transition group">
                        <span><i class="fas fa-plus-circle text-[#D7B259] mr-3"></i> Add Product</span>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-[#D7B259]"></i>
                    </a>
                    <a href="{{ route('admin.coupons.create') }}"
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-amber-50 transition group">
                        <span><i class="fas fa-ticket-alt text-[#D7B259] mr-3"></i> Create Coupon</span>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-[#D7B259]"></i>
                    </a>
                    <a href="{{ route('admin.categories.create') }}"
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-amber-50 transition group">
                        <span><i class="fas fa-folder text-[#D7B259] mr-3"></i> Add Category</span>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-[#D7B259]"></i>
                    </a>
                    <a href="{{ route('admin.brands.create') }}"
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-amber-50 transition group">
                        <span><i class="fas fa-trademark text-[#D7B259] mr-3"></i> Add Brand</span>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-[#D7B259]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div
                class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-[#D7B259] text-sm hover:underline">View All Orders
                    →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                                Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono font-medium text-gray-900">{{ $order->order_code }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $order->items->count() }} items</td>
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
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="text-[#D7B259] hover:text-amber-700 transition inline-flex items-center gap-1">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500">No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

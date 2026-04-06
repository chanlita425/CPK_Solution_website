{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Categories -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Categories</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCategories ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-folder text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.categories.index') }}" class="text-yellow-600 text-sm hover:text-yellow-700">Manage
                    Categories →</a>
            </div>
        </div>

        <!-- Total Brands -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Brands</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalBrands ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trademark text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.brands.index') }}" class="text-yellow-600 text-sm hover:text-yellow-700">Manage
                    Brands →</a>
            </div>
        </div>

        <!-- Total Products -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalProducts ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-box text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.products.index') }}" class="text-yellow-600 text-sm hover:text-yellow-700">Manage
                    Products →</a>
            </div>
        </div>

        <!-- Active Coupons -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Coupons</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $activeCoupons ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.coupons.index') }}" class="text-yellow-600 text-sm hover:text-yellow-700">Manage
                    Coupons →</a>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Orders Summary -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Orders Summary</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-bold text-blue-600">{{ $totalOrders ?? 0 }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Orders</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders ?? 0 }}</p>
                        <p class="text-sm text-gray-500 mt-1">Pending</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-2xl font-bold text-green-600">{{ $confirmedOrders ?? 0 }}</p>
                        <p class="text-sm text-gray-500 mt-1">Confirmed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}"
                    class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-yellow-50 transition group">
                    <span><i class="fas fa-plus-circle text-yellow-600 mr-3"></i> Add Product</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-yellow-600"></i>
                </a>
                <a href="{{ route('admin.coupons.create') }}"
                    class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-yellow-50 transition group">
                    <span><i class="fas fa-ticket-alt text-yellow-600 mr-3"></i> Create Coupon</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-yellow-600"></i>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-yellow-50 transition group">
                    <span><i class="fas fa-shopping-cart text-yellow-600 mr-3"></i> View Orders</span>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-yellow-600"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-yellow-600 text-sm hover:text-yellow-700">View All
                →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders ?? [] as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->order_code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $order->customer_name ?? 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-yellow-600">
                                ${{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                            @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'confirmed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="text-yellow-600 hover:text-yellow-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-shopping-cart text-4xl mb-3 block text-gray-300"></i>
                                <p>No orders yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

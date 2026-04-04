{{-- resources/views/admin/pages/dashboard/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-6">
            <!-- Categories Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 md:p-5 border-l-4" style="border-left-color: #D7B259;">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wide">Categories</p>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-1 md:mt-2">{{ $totalCategories ?? 0 }}</p>
                        <p class="text-green-600 text-xs mt-2">
                            <i class="fas fa-arrow-up text-xs"></i>
                            <span>+12% from last month</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(215, 178, 89, 0.1);">
                        <i class="fas fa-folder text-xl md:text-2xl" style="color: #D7B259;"></i>
                    </div>
                </div>
            </div>

            <!-- Brands Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 md:p-5 border-l-4" style="border-left-color: #D7B259;">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wide">Brands</p>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-1 md:mt-2">{{ $totalBrands ?? 0 }}</p>
                        <p class="text-green-600 text-xs mt-2">
                            <i class="fas fa-arrow-up text-xs"></i>
                            <span>+8% from last month</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(215, 178, 89, 0.1);">
                        <i class="fas fa-trademark text-xl md:text-2xl" style="color: #D7B259;"></i>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 md:p-5 border-l-4" style="border-left-color: #D7B259;">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wide">Products</p>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-1 md:mt-2">{{ $totalProducts ?? 0 }}</p>
                        <p class="text-green-600 text-xs mt-2">
                            <i class="fas fa-arrow-up text-xs"></i>
                            <span>+5% from last month</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(215, 178, 89, 0.1);">
                        <i class="fas fa-box text-xl md:text-2xl" style="color: #D7B259;"></i>
                    </div>
                </div>
            </div>

            <!-- Active Coupons Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 md:p-5 border-l-4" style="border-left-color: #D7B259;">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wide">Active Coupons</p>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-1 md:mt-2">{{ $activeCoupons ?? 0 }}</p>
                        <p class="text-gray-500 text-xs mt-2">
                            <i class="fas fa-minus text-xs"></i>
                            <span>Same as last month</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(215, 178, 89, 0.1);">
                        <i class="fas fa-ticket-alt text-xl md:text-2xl" style="color: #D7B259;"></i>
                    </div>
                </div>
            </div>

            <!-- Banners Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 md:p-5 border-l-4" style="border-left-color: #D7B259;">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wide">Banners</p>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800 mt-1 md:mt-2">{{ $totalBanners ?? 0 }}</p>
                        <p class="text-green-600 text-xs mt-2">
                            <i class="fas fa-arrow-up text-xs"></i>
                            <span>+3 new this week</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(215, 178, 89, 0.1);">
                        <i class="fas fa-image text-xl md:text-2xl" style="color: #D7B259;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Products Section -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-gray-800 mb-2 sm:mb-0">Recent Products</h3>
                <a href="{{ route('admin.products.index') }}" class="text-sm" style="color: #D7B259;">
                    View All Products <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $recentProducts = App\Models\Product::with(['category', 'brand'])->latest()->take(5)->get();
                        @endphp
                        @forelse($recentProducts as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center">
                                        @if($product->main_image)
                                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->title_en }}" class="w-8 h-8 rounded object-cover mr-3">
                                        @else
                                            <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-box text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                        <span class="text-sm text-gray-800">{{ Str::limit($product->title_en, 30) }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">{{ $product->sku }}</td>
                                <td class="px-5 py-3 text-sm font-semibold" style="color: #D7B259;">${{ number_format($product->price, 2) }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-sm {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-400">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-5 md:p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center p-4 rounded-lg transition-all group hover:bg-gray-50" style="background-color: rgba(215, 178, 89, 0.05);">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform" style="background-color: #D7B259;">
                            <i class="fas fa-plus-circle text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Add Product</p>
                            <p class="text-xs text-gray-500">Create new product</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 rounded-lg transition-all group hover:bg-gray-50" style="background-color: rgba(215, 178, 89, 0.05);">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform" style="background-color: #D7B259;">
                            <i class="fas fa-folder-plus text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Add Category</p>
                            <p class="text-xs text-gray-500">Create new category</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.brands.create') }}" class="flex items-center p-4 rounded-lg transition-all group hover:bg-gray-50" style="background-color: rgba(215, 178, 89, 0.05);">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform" style="background-color: #D7B259;">
                            <i class="fas fa-trademark text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Add Brand</p>
                            <p class="text-xs text-gray-500">Create new brand</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.coupons.create') }}" class="flex items-center p-4 rounded-lg transition-all group hover:bg-gray-50" style="background-color: rgba(215, 178, 89, 0.05);">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform" style="background-color: #D7B259;">
                            <i class="fas fa-ticket-alt text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Create Coupon</p>
                            <p class="text-xs text-gray-500">Add discount coupon</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="px-5 py-4 flex items-start space-x-3 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-box text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800">Welcome to CPK Admin Panel</p>
                            <p class="text-xs text-gray-500 mt-1">Just now</p>
                        </div>
                    </div>
                    <div class="px-5 py-4 flex items-start space-x-3 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800">Admin panel is ready to use</p>
                            <p class="text-xs text-gray-500 mt-1">Start managing your store</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

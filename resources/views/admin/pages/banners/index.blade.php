@extends('admin.layouts.app')

@section('title', 'Banners')
@section('header', 'Banners')

@section('content')
    <div class="admin-card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Banners Management</h2>
            <a href="{{ route('admin.banners.create') }}" class="btn-admin-primary">
                <i class="fas fa-plus mr-2"></i> Add Banner
            </a>
        </div>

        @if (session('success'))
            <div class="admin-alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hero Banners Section -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 flex items-center">
                <i class="fas fa-star text-primary mr-2"></i> Hero Banners
                <span class="text-sm text-gray-500 ml-2">(1370 x 498px)</span>
            </h3>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $heroBanners = $banners->where('type', 'hero'); @endphp
                        @forelse($heroBanners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                        class="w-32 h-20 object-cover rounded">
                                </td>
                                <td>
                                    <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Hero</span>
                                </td>
                                <td>{{ $banner->sort_order }}</td>
                                <td>
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.banners.edit', $banner) }}"
                                        class="text-blue-600 hover:text-blue-800 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">No hero banners found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Promotion Banners Section -->
        <div>
            <h3 class="text-xl font-semibold mb-4 flex items-center">
                <i class="fas fa-tag text-primary mr-2"></i> Promotion Banners
                <span class="text-sm text-gray-500 ml-2">(274 x 666px)</span>
            </h3>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $promoBanners = $banners->where('type', 'promotion'); @endphp
                        @forelse($promoBanners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                        class="w-20 h-32 object-cover rounded">
                                </td>
                                <td>
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Promotion</span>
                                </td>
                                <td>{{ $banner->sort_order }}</td>
                                <td>
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.banners.edit', $banner) }}"
                                        class="text-blue-600 hover:text-blue-800 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">No promotion banners found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $banners->links() }}
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Brands')
@section('header', 'Brands')

@section('content')
<div class="admin-card p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Brands List</h2>
        <a href="{{ route('admin.brands.create') }}" class="btn-admin-primary">
            <i class="fas fa-plus mr-2"></i> Add Brand
        </a>
    </div>

    @if(session('success'))
        <div class="admin-alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Name (EN)</th>
                    <th>Name (KH)</th>
                    <th>Products</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" class="w-10 h-10 object-cover rounded">
                        @else
                            <i class="fas fa-trademark text-gray-400 text-2xl"></i>
                        @endif
                    </td>
                    <td>{{ $brand->name_en }}</td>
                    <td>{{ $brand->name_kh }}</td>
                    <td>{{ $brand->products_count ?? $brand->products->count() }}</td>
                    <td>{{ $brand->sort_order }}</td>
                    <td>
                        <span class="px-2 py-1 rounded text-xs {{ $brand->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-gray-500">No brands found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $brands->links() }}
    </div>
</div>
@endsection

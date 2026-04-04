@extends('admin.layouts.app')

@section('title', 'Categories')
@section('header', 'Categories')

@section('content')
    <div class="admin-card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Categories List</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn-admin-primary">
                <i class="fas fa-plus mr-2"></i> Add Category
            </a>
        </div>

        @if (session('success'))
            <div class="admin-alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name (EN)</th>
                        <th>Name (KH)</th>
                        <th>Products</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                @if ($category->icon)
                                    <img src="{{ asset('storage/' . $category->icon) }}"
                                        class="w-10 h-10 object-cover rounded">
                                @else
                                    <i class="fas fa-folder text-gray-400 text-2xl"></i>
                                @endif
                            </td>
                            <td>{{ $category->name_en }}</td>
                            <td>{{ $category->name_kh }}</td>
                            <td>{{ $category->products_count ?? $category->products->count() }}</td>
                            <td>{{ $category->sort_order }}</td>
                            <td>
                                <span
                                    class="px-2 py-1 rounded text-xs {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('Are you sure? This will also delete all products in this category.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-500">No categories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>

    <style>
        .admin-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .admin-alert-success {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.5rem;
        }
    </style>
@endsection

@extends('admin.layouts.app')

@section('title', 'Categories')
@section('header', 'Categories')
@section('subheader', 'Manage your product categories')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <p class="text-gray-600 text-sm">Manage your product categories and organize your store</p>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle"></i> Add Category
            </a>
        </div>

        <!-- Filter Toolbar -->
        @include('admin.components.filter-toolbar', [
            'searchPlaceholder' => 'Search categories by name...',
            'searchValue' => request('search'),
            'filters' => [['type' => 'status']],
            'showReset' => true,
        ])

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg p-4">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                                (English)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                                (Khmer)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Products</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if ($category->icon_image)
                                        <img src="{{ asset('storage/' . $category->icon_image) }}"
                                            alt="{{ $category->name_en }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-folder text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name_en }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->name_kh }}</td>
                                <td class="px-6 py-4">
                                    <button onclick="toggleStatus({{ $category->id }})"
                                        class="px-2 py-1 text-xs rounded-full transition-all hover:opacity-80
                                {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->products_count ?? 0 }}</td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $category->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="text-blue-600 hover:text-blue-700 p-1 transition">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            onclick="confirmDelete('{{ route('admin.categories.destroy', $category->id) }}', '{{ $category->name_en }}')"
                                            class="text-red-600 hover:text-red-700 p-1 transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500 mb-2">No categories found</p>
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="text-[#D7B259] hover:underline text-sm">Create your first category →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        function toggleStatus(id) {
            fetch(`/admin/categories/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof showToast === 'function') {
                            showToast('Status updated successfully', 'success');
                        } else {
                            alert('Status updated successfully');
                        }
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        if (typeof showToast === 'function') {
                            showToast('Failed to update status', 'error');
                        } else {
                            alert('Failed to update status');
                        }
                    }
                })
                .catch(() => {
                    if (typeof showToast === 'function') {
                        showToast('An error occurred', 'error');
                    } else {
                        alert('An error occurred');
                    }
                });
        }
    </script>
@endsection

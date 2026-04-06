{{-- resources/views/admin/categories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Categories')
@section('header', 'Categories')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Manage your product categories</p>
        <a href="{{ route('admin.categories.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Add Category
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name (English)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name (Khmer)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                @if ($category->icon_image)
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ asset('storage/' . $category->icon_image) }}"
                                            alt="{{ $category->name_en }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-folder text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">{{ $category->name_en }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $category->name_kh }}</td>
                            <td class="px-6 py-4">
                                <button onclick="toggleStatus({{ $category->id }})"
                                    class="px-2 py-1 text-xs rounded-full transition
                            {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="text-blue-600 hover:text-blue-700 p-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteCategory({{ $category->id }})"
                                        class="text-red-600 hover:text-red-700 p-1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-folder-open text-4xl mb-2 block"></i>
                                No categories found. Click "Add Category" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Failed to update status', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Failed to update status', 'error');
                });
        }

        function deleteCategory(id) {
            Swal.fire({
                title: 'Delete Category?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/categories/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire('Error', 'Failed to delete', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to delete category', 'error');
                        });
                }
            });
        }
    </script>
@endsection

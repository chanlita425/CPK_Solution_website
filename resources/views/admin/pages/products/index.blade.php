{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Products')
@section('header', 'Products')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Manage your product inventory</p>
        <a href="{{ route('admin.products.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Add Product
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                @if ($product->images && $product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                        alt="{{ $product->name_en }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">{{ $product->name_en }}</span>
                                <div class="text-xs text-gray-500">{{ $product->name_kh }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->SKU }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-yellow-600">
                                ${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm {{ $product->quantity <= 5 ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name_en ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <button onclick="toggleStatus({{ $product->id }})"
                                    class="px-2 py-1 text-xs rounded-full transition
                            {{ $product->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="text-blue-600 hover:text-blue-700 p-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-700 p-1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-2 block"></i>
                                No products found. Click "Add Product" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleStatus(id) {
            fetch(`/admin/products/${id}/toggle-status`, {
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

        function deleteProduct(id) {
            Swal.fire({
                title: 'Delete Product?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/products/${id}`, {
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
                                Swal.fire('Error', data.message || 'Failed to delete', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to delete product', 'error');
                        });
                }
            });
        }
    </script>
@endsection

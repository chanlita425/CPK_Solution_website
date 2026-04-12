@extends('admin.layouts.app')

@section('title', 'Products')
@section('header', 'Products')
@section('subheader', 'Manage your product inventory')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <p class="text-gray-600 text-sm">Manage your products and pricing</p>
            <a href="{{ route('admin.products.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
        </div>

        <!-- Filter Toolbar -->
        @php
            $categoryOptions = [];
            if (isset($categories)) {
                foreach ($categories as $cat) {
                    $categoryOptions[] = ['value' => $cat->id, 'label' => $cat->name_en];
                }
            }

            $brandOptions = [];
            if (isset($brands)) {
                foreach ($brands as $brand) {
                    $brandOptions[] = ['value' => $brand->id, 'label' => $brand->name_en];
                }
            }

            $filters = [
                [
                    'type' => 'select',
                    'name' => 'category',
                    'placeholder' => 'All Categories',
                    'options' => $categoryOptions,
                ],
                ['type' => 'select', 'name' => 'brand', 'placeholder' => 'All Brands', 'options' => $brandOptions],
                ['type' => 'status', 'name' => 'status'],
            ];
        @endphp

        @include('admin.components.filter-toolbar', [
            'searchPlaceholder' => 'Search by SKU or product name...',
            'searchValue' => request('search'),
            'filters' => $filters,
            'showReset' => true,
        ])

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name (English)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name (Khmer)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                         </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if ($product->images && $product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                            alt="{{ $product->name_en }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                 </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name_en }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->name_kh }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $product->SKU }}</td>
                                <td class="px-6 py-4 font-semibold text-[#D7B259]">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name_en ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $product->brand->name_en ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <button onclick="toggleStatus({{ $product->id }})"
                                        class="px-2 py-1 text-xs rounded-full transition-all hover:opacity-80
                                        {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                 </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="text-blue-600 hover:text-blue-700 p-1 transition">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}', '{{ $product->name_en }}')"
                                            class="text-red-600 hover:text-red-700 p-1 transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                 </td>
                             </tr>
                        @empty
                             <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-box-open text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500 mb-2">No products found</p>
                                    <a href="{{ route('admin.products.create') }}"
                                        class="text-[#D7B259] hover:underline text-sm">Add your first product →</a>
                                 </td>
                             </tr>
                        @endforelse
                    </tbody>
                 </table>
            </div>
        </div>

        <div class="mt-6">
            @include('admin.components.pagination', ['paginator' => $products])
        </div>
    </div>

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

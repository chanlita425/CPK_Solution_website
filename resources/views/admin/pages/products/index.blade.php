@extends('admin.layouts.app')

@section('title', 'Products')
@section('header', 'Products')

@section('content')
<div class="admin-card p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Products List</h2>
        <a href="{{ route('admin.products.create') }}" class="btn-admin-primary">
            <i class="fas fa-plus mr-2"></i> Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="admin-alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-4">
            <input type="text" name="search" placeholder="Search by title, SKU, or model..."
                   class="admin-form-input flex-1" value="{{ request('search') }}">
            <button type="submit" class="btn-admin-primary">
                <i class="fas fa-search mr-2"></i> Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" class="btn-admin-secondary">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title (EN)</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><input type="checkbox" class="product-checkbox" value="{{ $product->id }}"></td>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="w-12 h-12 object-cover rounded">
                        @else
                            <i class="fas fa-box text-gray-400 text-2xl"></i>
                        @endif
                    </td>
                    <td>{{ Str::limit($product->title_en, 30) }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name_en ?? 'N/A' }}</td>
                    <td>{{ $product->brand->name_en ?? 'N/A' }}</td>
                    <td class="font-semibold">${{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="px-2 py-1 rounded text-xs {{ $product->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td>
                        <span class="px-2 py-1 rounded text-xs {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline delete-form">
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
                    <td colspan="11" class="text-center py-8 text-gray-500">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <div>
            <button id="bulkDelete" class="btn-admin-danger hidden">
                <i class="fas fa-trash mr-2"></i> Delete Selected
            </button>
        </div>
        <div>
            {{ $products->links() }}
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = this.checked);
    toggleBulkDelete();
});

document.querySelectorAll('.product-checkbox').forEach(cb => {
    cb.addEventListener('change', toggleBulkDelete);
});

function toggleBulkDelete() {
    const checked = document.querySelectorAll('.product-checkbox:checked').length;
    const bulkBtn = document.getElementById('bulkDelete');
    if (bulkBtn) {
        bulkBtn.classList.toggle('hidden', checked === 0);
    }
}

document.getElementById('bulkDelete')?.addEventListener('click', function() {
    const selected = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
    if (selected.length && confirm(`Delete ${selected.length} products?`)) {
        // Submit bulk delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.products.bulk-delete") }}';
        form.innerHTML = `
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" value="${selected.join(',')}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
});
</script>
@endsection

{{-- resources/views/admin/pages/brands/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Brands')
@section('header', 'Brands')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-600">Manage your product brands</p>
    <a href="{{ route('admin.brands.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg transition flex items-center gap-2">
        <i class="fas fa-plus-circle"></i> Add Brand
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name (English)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name (Khmer)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @if($brand->logo_image)
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $brand->logo_image) }}" alt="{{ $brand->name_en }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-trademark text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $brand->name_en }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $brand->name_kh }}</td>
                    <td class="px-6 py-4">
                        <button onclick="toggleStatus({{ $brand->id }})"
                            class="px-2 py-1 text-xs rounded-full transition
                            {{ $brand->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $brand->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="text-blue-600 hover:text-blue-700 p-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteBrand({{ $brand->id }})" class="text-red-600 hover:text-red-700 p-1">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-trademark text-4xl mb-2 block"></i>
                        No brands found. Click "Add Brand" to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $brands->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleStatus(id) {
    fetch(`/admin/brands/${id}/toggle-status`, {
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

function deleteBrand(id) {
    Swal.fire({
        title: 'Delete Brand?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/brands/${id}`, {
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
                Swal.fire('Error', 'Failed to delete brand', 'error');
            });
        }
    });
}
</script>
@endsection

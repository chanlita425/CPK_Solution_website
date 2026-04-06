{{-- resources/views/admin/coupons/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('header', 'Coupons')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Manage discount coupons for your store</p>
        <a href="{{ route('admin.coupons.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Add Coupon
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-mono font-medium text-gray-900">{{ $coupon->code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="capitalize text-sm text-gray-600">{{ $coupon->type }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-yellow-600">
                                @if ($coupon->type == 'percent')
                                    {{ $coupon->value }}%
                                @else
                                    ${{ number_format($coupon->value, 2) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if ($coupon->min_order_amount > 0)
                                    ${{ number_format($coupon->min_order_amount, 2) }}
                                @else
                                    No minimum
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if ($coupon->start_date || $coupon->end_date)
                                    {{ $coupon->start_date ? $coupon->start_date->format('M d, Y') : 'Any' }}
                                    -
                                    {{ $coupon->end_date ? $coupon->end_date->format('M d, Y') : 'Any' }}
                                @else
                                    Always valid
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="toggleStatus({{ $coupon->id }})"
                                    class="px-2 py-1 text-xs rounded-full transition
                            {{ $coupon->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                        class="text-blue-600 hover:text-blue-700 p-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteCoupon({{ $coupon->id }})"
                                        class="text-red-600 hover:text-red-700 p-1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-ticket-alt text-4xl mb-2 block"></i>
                                No coupons found. Click "Add Coupon" to create your first discount code.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $coupons->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleStatus(id) {
            fetch(`/admin/coupons/${id}/toggle-status`, {
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

        function deleteCoupon(id) {
            Swal.fire({
                title: 'Delete Coupon?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/coupons/${id}`, {
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
                            Swal.fire('Error', 'Failed to delete coupon', 'error');
                        });
                }
            });
        }
    </script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('header', 'Coupons')
@section('subheader', 'Manage discount coupons for your store')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <p class="text-gray-600 text-sm">Create and manage discount codes for your customers</p>
            <a href="{{ route('admin.coupons.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle"></i> Add Coupon
            </a>
        </div>

        <!-- Filter Toolbar -->
        @php
            $filters = [['type' => 'status', 'name' => 'status']];
        @endphp

        @include('admin.components.filter-toolbar', [
            'searchPlaceholder' => 'Search coupons by code...',
            'searchValue' => request('search'),
            'filters' => $filters,
            'showReset' => true,
        ])

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min
                                Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valid
                                From</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valid
                                To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($coupons as $coupon)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono font-semibold text-gray-900">{{ $coupon->code }}</td>
                                <td class="px-6 py-4 capitalize text-sm text-gray-600">{{ $coupon->type }}</td>
                                <td class="px-6 py-4 font-semibold text-[#D7B259]">
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
                                        <span class="text-gray-400">No minimum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $coupon->start_date ? $coupon->start_date->format('M d, Y') : 'Any' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $coupon->end_date ? $coupon->end_date->format('M d, Y') : 'Any' }}
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="toggleStatus({{ $coupon->id }})"
                                        class="px-2 py-1 text-xs rounded-full transition-all hover:opacity-80
                                {{ $coupon->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                            class="text-blue-600 hover:text-blue-700 p-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            onclick="confirmDelete('{{ route('admin.coupons.destroy', $coupon->id) }}', '{{ $coupon->code }}')"
                                            class="text-red-600 hover:text-red-700 p-1">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-ticket-alt text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500 mb-2">No coupons found</p>
                                    <a href="{{ route('admin.coupons.create') }}"
                                        class="text-[#D7B259] hover:underline text-sm">Create your first coupon →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $coupons->appends(request()->query())->links() }}
        </div>
    </div>

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
                        showToast('Status updated successfully', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('Failed to update status', 'error');
                    }
                })
                .catch(() => showToast('An error occurred', 'error'));
        }
    </script>
@endsection

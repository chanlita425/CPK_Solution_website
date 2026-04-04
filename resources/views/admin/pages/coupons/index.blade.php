@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('header', 'Coupons')

@section('content')
    <div class="admin-card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Coupons Management</h2>
            <a href="{{ route('admin.coupons.create') }}" class="btn-admin-primary">
                <i class="fas fa-plus mr-2"></i> Add Coupon
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
                        <th>Code</th>
                        <th>Discount Type</th>
                        <th>Discount Value</th>
                        <th>Min. Order</th>
                        <th>Valid Period</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td>
                                <span class="font-mono font-bold text-primary">{{ $coupon->code }}</span>
                            </td>
                            <td>
                                <span
                                    class="px-2 py-1 rounded text-xs {{ $coupon->discount_type == 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($coupon->discount_type) }}
                                </span>
                            </td>
                            <td>
                                @if ($coupon->discount_type == 'percentage')
                                    {{ $coupon->discount_value }}%
                                @else
                                    ${{ number_format($coupon->discount_value, 2) }}
                                @endif
                            </td>
                            <td>${{ number_format($coupon->minimum_order, 2) }}</td>
                            <td>
                                {{ date('d/m/Y', strtotime($coupon->valid_from)) }} -
                                {{ date('d/m/Y', strtotime($coupon->valid_until)) }}
                                @if (now() > $coupon->valid_until)
                                    <span class="text-red-500 text-xs block">Expired</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                                </div>
                                @if ($coupon->usage_limit)
                                    <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                        <div class="bg-primary rounded-full h-1"
                                            style="width: {{ ($coupon->used_count / $coupon->usage_limit) * 100 }}%"></div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $coupon->is_active && $coupon->valid_until >= now() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $coupon->is_active && $coupon->valid_until >= now() ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if (!$coupon->is_active)
                                        <span class="text-xs text-gray-500">Disabled</span>
                                    @elseif($coupon->valid_until < now())
                                        <span class="text-xs text-red-500">Expired</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-gray-500">No coupons found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $coupons->links() }}
        </div>
    </div>
@endsection

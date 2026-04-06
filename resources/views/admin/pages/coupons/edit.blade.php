{{-- resources/views/admin/coupons/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Coupon')
@section('header', 'Edit Coupon')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-yellow-600">
            <i class="fas fa-arrow-left mr-2"></i> Back to Coupons
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST"
        class="bg-white rounded-xl shadow-sm overflow-hidden max-w-2xl">
        @csrf
        @method('PUT')

        <div class="p-6">
            <div class="space-y-6">
                <!-- Coupon Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 font-mono uppercase"
                        placeholder="SUMMER2024">
                    <p class="text-xs text-gray-500 mt-1">Use uppercase letters and numbers only. Customers will enter this
                        code at checkout.</p>
                </div>

                <!-- Type & Value Row -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount Type <span
                                class="text-red-500">*</span></label>
                        <select name="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>
                                Percentage (%)</option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed
                                Amount ($)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Value <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="10">
                        </div>
                    </div>
                </div>

                <!-- Minimum Order Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" name="min_order_amount"
                            value="{{ old('min_order_amount', $coupon->min_order_amount) }}" step="0.01"
                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="0">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimum order amount required to use this coupon. Leave 0 for no
                        minimum.</p>
                </div>

                <!-- Valid Period -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                        <p class="text-xs text-gray-500 mt-1">Leave empty for immediate start</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date"
                            value="{{ old('end_date', $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                        <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration</p>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-500">
                        <span class="ml-2 text-sm text-gray-700">Active (coupon can be used by customers)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.coupons.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
            <button type="submit"
                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-lg transition">Update
                Coupon</button>
        </div>
    </form>
@endsection

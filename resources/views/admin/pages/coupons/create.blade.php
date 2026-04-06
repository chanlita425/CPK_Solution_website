@extends('admin.layouts.app')

@section('title', 'Add Coupon')
@section('header', 'Add New Coupon')
@section('subheader', 'Create a discount coupon for customers')

@section('content')
<div class="max-w-2xl mx-auto pb-8 px-4 sm:px-0">
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-[#D7B259] transition inline-flex items-center gap-2 text-sm sm:text-base">
            <i class="fas fa-arrow-left text-xs sm:text-sm"></i> Back to Coupons
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden relative">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="p-4 sm:p-6 space-y-5 sm:space-y-6">
                <!-- Coupon Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-ticket-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                        <input type="text" name="code" value="{{ old('code') }}" required
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent font-mono uppercase @error('code') border-red-500 @enderror text-sm sm:text-base min-h-[42px]"
                               placeholder="SUMMER2024">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Use uppercase letters and numbers only.</p>
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Discount Type & Value -->
                <div class="flex flex-col sm:grid sm:grid-cols-2 gap-4">
                    <div>
                        @php
                            $discountTypes = [
                                ['value' => 'percent', 'label' => 'Percentage (%)'],
                                ['value' => 'fixed', 'label' => 'Fixed Amount ($)']
                            ];
                        @endphp
                        @include('admin.components.styled-select', [
                            'name' => 'type',
                            'options' => $discountTypes,
                            'selected' => old('type', 'percent'),
                            'label' => 'Discount Type',
                            'required' => true,
                            'icon' => 'fas fa-percent'
                        ])
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Value <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                            <input type="number" name="value" value="{{ old('value') }}" step="0.01" required
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('value') border-red-500 @enderror text-sm sm:text-base min-h-[42px]"
                                   placeholder="0.00">
                        </div>
                        @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Minimum Order Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Amount</label>
                    <div class="relative">
                        <i class="fas fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                        <input type="number" name="min_order_amount" value="{{ old('min_order_amount', 0) }}" step="0.01"
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent text-sm sm:text-base min-h-[42px]">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimum order amount required. Leave 0 for no minimum.</p>
                </div>

                <!-- Valid Period - Using Flatpickr -->
                <div class="flex flex-col sm:grid sm:grid-cols-2 gap-4">
                    <div>
                        @include('admin.components.date-picker', [
                            'name' => 'start_date',
                            'value' => old('start_date'),
                            'label' => 'Start Date',
                            'placeholder' => 'Select start date'
                        ])
                        <p class="text-xs text-gray-500 mt-1">Leave empty for immediate start</p>
                    </div>

                    <div>
                        @include('admin.components.date-picker', [
                            'name' => 'end_date',
                            'value' => old('end_date'),
                            'label' => 'End Date',
                            'placeholder' => 'Select end date'
                        ])
                        <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration</p>
                    </div>
                </div>

                <!-- Status - Toggle Switch -->
                <div class="pt-4 border-t border-gray-200">
                    @include('admin.components.toggle-switch', [
                        'name' => 'is_active',
                        'checked' => old('is_active', true),
                        'label' => 'Coupon Status',
                        'helper' => 'Enable this to allow customers to use this coupon at checkout.'
                    ])
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.coupons.index') }}" class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium text-center">
                    Cancel
                </a>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition font-medium">
                    <i class="fas fa-save mr-2"></i> Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

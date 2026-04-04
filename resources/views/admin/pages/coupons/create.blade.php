@extends('admin.layouts.app')

@section('title', 'Create Coupon')
@section('header', 'Create Coupon')

@section('content')
    <div class="admin-card p-6">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="admin-form-label">Coupon Code *</label>
                    <input type="text" name="code" class="admin-form-input" value="{{ old('code') }}" required
                        placeholder="e.g., SUMMER2024">
                    <p class="text-xs text-gray-500 mt-1">Use uppercase letters and numbers only</p>
                    @error('code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Discount Type *</label>
                    <select name="discount_type" class="admin-form-input" required id="discountType">
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage
                            (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)
                        </option>
                    </select>
                    @error('discount_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Discount Value *</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="discount_value" class="admin-form-input"
                            value="{{ old('discount_value') }}" required>
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" id="discountSymbol">
                            {{ old('discount_type') == 'percentage' ? '%' : '$' }}
                        </span>
                    </div>
                    @error('discount_value')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Minimum Order Amount</label>
                    <input type="number" step="0.01" name="minimum_order" class="admin-form-input"
                        value="{{ old('minimum_order', 0) }}">
                    <p class="text-xs text-gray-500 mt-1">Leave 0 for no minimum requirement</p>
                    @error('minimum_order')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Valid From *</label>
                    <input type="date" name="valid_from" class="admin-form-input" value="{{ old('valid_from') }}"
                        required>
                    @error('valid_from')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Valid Until *</label>
                    <input type="date" name="valid_until" class="admin-form-input" value="{{ old('valid_until') }}"
                        required>
                    @error('valid_until')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Usage Limit</label>
                    <input type="number" name="usage_limit" class="admin-form-input" value="{{ old('usage_limit') }}"
                        placeholder="Leave empty for unlimited">
                    <p class="text-xs text-gray-500 mt-1">Maximum number of times this coupon can be used</p>
                    @error('usage_limit')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Status</label>
                    <select name="is_active" class="admin-form-input">
                        <option value="1" {{ old('is_active') ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('is_active') ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.coupons.index') }}" class="btn-admin-secondary mr-3">Cancel</a>
                <button type="submit" class="btn-admin-primary">Create Coupon</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('discountType')?.addEventListener('change', function() {
            const symbol = document.getElementById('discountSymbol');
            if (this.value === 'percentage') {
                symbol.textContent = '%';
            } else {
                symbol.textContent = '$';
            }
        });
    </script>
@endsection

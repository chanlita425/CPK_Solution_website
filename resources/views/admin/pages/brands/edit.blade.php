@extends('admin.layouts.app')

@section('title', 'Edit Brand')
@section('header', 'Edit Brand')

@section('content')
<div class="admin-card p-6">
    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="admin-form-label">Name (English) *</label>
                <input type="text" name="name_en" class="admin-form-input" value="{{ old('name_en', $brand->name_en) }}" required>
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Name (Khmer) *</label>
                <input type="text" name="name_kh" class="admin-form-input" value="{{ old('name_kh', $brand->name_kh) }}" required>
                @error('name_kh') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Current Logo</label>
                @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" class="w-20 h-20 object-cover rounded">
                @else
                    <p class="text-gray-500">No logo uploaded</p>
                @endif
            </div>

            <div>
                <label class="admin-form-label">New Logo (Optional)</label>
                <input type="file" name="logo" class="admin-form-input" accept="image/*" onchange="previewImage(this)">
                <div id="logoPreview" class="mt-2 hidden">
                    <img id="preview" class="w-20 h-20 object-cover rounded">
                </div>
                <p class="text-xs text-gray-500 mt-1">Recommended: 200x200px</p>
                @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Sort Order</label>
                <input type="number" name="sort_order" class="admin-form-input" value="{{ old('sort_order', $brand->sort_order) }}">
            </div>

            <div>
                <label class="admin-form-label">Status</label>
                <select name="is_active" class="admin-form-input">
                    <option value="1" {{ old('is_active', $brand->is_active) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !old('is_active', $brand->is_active) ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.brands.index') }}" class="btn-admin-secondary mr-3">Cancel</a>
            <button type="submit" class="btn-admin-primary">Update Brand</button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('logoPreview');
    const img = document.getElementById('preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

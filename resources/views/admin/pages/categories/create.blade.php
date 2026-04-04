@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('header', 'Create Category')

@section('content')
<div class="admin-card p-6">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="admin-form-label">Name (English) *</label>
                <input type="text" name="name_en" class="admin-form-input" value="{{ old('name_en') }}" required>
                @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Name (Khmer) *</label>
                <input type="text" name="name_kh" class="admin-form-input" value="{{ old('name_kh') }}" required>
                @error('name_kh') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Icon Image</label>
                <input type="file" name="icon" class="admin-form-input" accept="image/*" onchange="previewImage(this)">
                <div id="iconPreview" class="mt-2 hidden">
                    <img id="preview" class="w-20 h-20 object-cover rounded">
                </div>
                @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Sort Order</label>
                <input type="number" name="sort_order" class="admin-form-input" value="{{ old('sort_order', 0) }}">
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
            <a href="{{ route('admin.categories.index') }}" class="btn-admin-secondary mr-3">Cancel</a>
            <button type="submit" class="btn-admin-primary">Create Category</button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('iconPreview');
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

@extends('admin.layouts.app')

@section('title', 'Create Product')
@section('header', 'Create Product')

@section('content')
<div class="admin-card p-6">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="admin-form-label">Category *</label>
                <select name="category_id" class="admin-form-input" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_en }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Brand *</label>
                <select name="brand_id" class="admin-form-input" required>
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name_en }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">SKU *</label>
                <input type="text" name="sku" class="admin-form-input" value="{{ old('sku') }}" required>
                @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Model Number</label>
                <input type="text" name="model_number" class="admin-form-input" value="{{ old('model_number') }}">
                @error('model_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Price *</label>
                <input type="number" step="0.01" name="price" class="admin-form-input" value="{{ old('price') }}" required>
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Quantity *</label>
                <input type="number" name="quantity" class="admin-form-input" value="{{ old('quantity', 0) }}" required>
                @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="admin-form-label">Title (English) *</label>
                <input type="text" name="title_en" class="admin-form-input" value="{{ old('title_en') }}" required>
                @error('title_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="admin-form-label">Title (Khmer) *</label>
                <input type="text" name="title_kh" class="admin-form-input" value="{{ old('title_kh') }}" required>
                @error('title_kh') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="admin-form-label">Specification (English)</label>
                <textarea name="specification_en" rows="5" class="admin-form-input">{{ old('specification_en') }}</textarea>
                @error('specification_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="admin-form-label">Specification (Khmer)</label>
                <textarea name="specification_kh" rows="5" class="admin-form-input">{{ old('specification_kh') }}</textarea>
                @error('specification_kh') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="admin-form-label">Product Images</label>
                <input type="file" name="images[]" class="admin-form-input" accept="image/*" multiple onchange="previewImages(this)">
                <div id="imagesPreview" class="grid grid-cols-4 gap-4 mt-3"></div>
                <p class="text-xs text-gray-500 mt-1">You can select multiple images. First image will be the main image.</p>
                @error('images.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="admin-form-label">Status</label>
                <select name="is_active" class="admin-form-input">
                    <option value="1" {{ old('is_active') ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !old('is_active') ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="admin-form-label">Featured</label>
                <select name="is_featured" class="admin-form-input">
                    <option value="1" {{ old('is_featured') ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !old('is_featured') ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.products.index') }}" class="btn-admin-secondary mr-3">Cancel</a>
            <button type="submit" class="btn-admin-primary">Create Product</button>
        </div>
    </form>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagesPreview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded border">
                    <span class="absolute top-1 right-1 bg-primary text-white text-xs px-1 rounded">${index === 0 ? 'Main' : index+1}</span>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection

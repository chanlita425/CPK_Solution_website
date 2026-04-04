@extends('admin.layouts.app')

@section('title', 'Create Banner')
@section('header', 'Create Banner')

@section('content')
    <div class="admin-card p-6">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="admin-form-label">Banner Type *</label>
                    <select name="type" class="admin-form-input" required id="bannerType">
                        <option value="">Select Type</option>
                        <option value="hero" {{ old('type') == 'hero' ? 'selected' : '' }}>Hero Banner (1370 x 498px)
                        </option>
                        <option value="promotion" {{ old('type') == 'promotion' ? 'selected' : '' }}>Promotion Banner (274 x
                            666px)</option>
                    </select>
                    @error('type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="admin-form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="admin-form-input" value="{{ old('sort_order', 0) }}">
                    @error('sort_order')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="admin-form-label">Banner Image *</label>
                    <input type="file" name="image" class="admin-form-input" accept="image/*" required
                        onchange="previewImage(this)">
                    <div id="imagePreview" class="mt-3 hidden">
                        <img id="preview" class="max-w-full h-auto rounded-lg border">
                    </div>
                    <div id="sizeHint" class="text-xs text-gray-500 mt-1"></div>
                    @error('image')
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
                <a href="{{ route('admin.banners.index') }}" class="btn-admin-secondary mr-3">Cancel</a>
                <button type="submit" class="btn-admin-primary">Create Banner</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const img = document.getElementById('preview');
            const sizeHint = document.getElementById('sizeHint');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');

                    // Get image dimensions
                    const tempImg = new Image();
                    tempImg.onload = function() {
                        const type = document.getElementById('bannerType').value;
                        if (type === 'hero') {
                            if (this.width !== 1370 || this.height !== 498) {
                                sizeHint.innerHTML =
                                    '<span class="text-red-500">⚠ Warning: Recommended size is 1370 x 498px. Current: ' +
                                    this.width + ' x ' + this.height + 'px</span>';
                            } else {
                                sizeHint.innerHTML = '<span class="text-green-500">✓ Perfect size!</span>';
                            }
                        } else if (type === 'promotion') {
                            if (this.width !== 274 || this.height !== 666) {
                                sizeHint.innerHTML =
                                    '<span class="text-red-500">⚠ Warning: Recommended size is 274 x 666px. Current: ' +
                                    this.width + ' x ' + this.height + 'px</span>';
                            } else {
                                sizeHint.innerHTML = '<span class="text-green-500">✓ Perfect size!</span>';
                            }
                        }
                    };
                    tempImg.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('bannerType')?.addEventListener('change', function() {
            const sizeHint = document.getElementById('sizeHint');
            if (this.value === 'hero') {
                sizeHint.innerHTML = 'Recommended size: 1370 x 498 pixels';
            } else if (this.value === 'promotion') {
                sizeHint.innerHTML = 'Recommended size: 274 x 666 pixels';
            } else {
                sizeHint.innerHTML = '';
            }
        });
    </script>
@endsection

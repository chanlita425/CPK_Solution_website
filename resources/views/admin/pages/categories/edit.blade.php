@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('header', 'Edit Category')
@section('subheader', 'Update category information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-[#D7B259] transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Categories
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <div>
                        <label class="form-label">Name (English) <span class="text-red-500">*</span></label>
                        <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('name_en') border-red-500 @enderror">
                        @error('name_en')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Name (Khmer) <span class="text-red-500">*</span></label>
                        <input type="text" name="name_kh" value="{{ old('name_kh', $category->name_kh) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('name_kh') border-red-500 @enderror">
                        @error('name_kh')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Category Icon</label>

                        {{-- Display existing image - SIMPLE like Product --}}
                        @if($category->icon_image)
                            <div id="existingImage" class="mb-4">
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $category->icon_image) }}"
                                        class="w-24 h-24 object-cover rounded-lg border">
                                    <button type="button" onclick="removeExistingImage()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Current icon. Click X to remove.</p>
                            </div>
                        @endif

                        {{-- Upload area - ALWAYS visible --}}
                        <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-[#D7B259] transition">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-600">Click or drag new image here to upload</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF, WEBP up to 2MB</p>
                        </div>

                        {{-- Preview for new image --}}
                        <div id="previewContainer" class="mt-4 hidden">
                            <div class="relative inline-block">
                                <img id="imagePreview" class="w-24 h-24 object-cover rounded-lg border">
                                <button type="button" onclick="removeNewImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">New icon to upload</p>
                        </div>

                        <input type="file" name="icon_image" id="imageInput" accept="image/*" class="hidden">
                        <input type="hidden" name="remove_icon" id="removeIcon" value="">

                        @error('icon_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-400 mt-2">Upload a new icon to replace the current one. Leave empty to keep current icon.</p>
                    </div>

                    <!-- Status - Toggle Switch -->
                    <div class="pt-4 border-t border-gray-200">
                        @include('admin.components.toggle-switch', [
                            'name' => 'is_active',
                            'checked' => old('is_active', $category->is_active),
                            'label' => 'Category Status',
                            'helper' => 'Enable this to show the category on your website. Disable to hide it temporarily.',
                        ])
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition">Update Category</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropzone = document.getElementById('dropzone');
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('imagePreview');
        const existingImage = document.getElementById('existingImage');
        const removeIcon = document.getElementById('removeIcon');

        if (dropzone) {
            dropzone.addEventListener('click', () => imageInput.click());

            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-[#D7B259]', 'bg-amber-50');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-[#D7B259]', 'bg-amber-50');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-[#D7B259]', 'bg-amber-50');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) handleNewImage(file);
            });
        }

        imageInput?.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) handleNewImage(e.target.files[0]);
        });

        function handleNewImage(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
                dropzone.classList.add('opacity-50', 'pointer-events-none');
            };
            reader.readAsDataURL(file);
        }

        function removeExistingImage() {
            if (existingImage) {
                existingImage.remove();
            }
            if (removeIcon) removeIcon.value = '1';
            dropzone.classList.remove('opacity-50', 'pointer-events-none');
        }

        function removeNewImage() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            dropzone.classList.remove('opacity-50', 'pointer-events-none');
        }
    </script>
@endsection

{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('header', 'Edit Category')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-yellow-600">
            <i class="fas fa-arrow-left mr-2"></i> Back to Categories
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

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow-sm overflow-hidden max-w-2xl">
        @csrf
        @method('PUT')

        <div class="p-6">
            <div class="space-y-6">
                <!-- Name English -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name (English) <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <!-- Name Khmer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name (Khmer) <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name_kh" value="{{ old('name_kh', $category->name_kh) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <!-- Category Icon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Icon</label>

                    @if ($category->icon_image)
                        <div id="existingImageContainer" class="mb-4">
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $category->icon_image) }}"
                                    class="w-32 h-32 object-cover rounded-lg border">
                                <button type="button" onclick="removeExistingImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div id="imageUploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-yellow-500 transition {{ $category->icon_image ? 'hidden' : '' }}">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                        <p class="text-gray-600">Click or drag new image here</p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                    </div>

                    <div id="newImagePreviewContainer" class="mt-4 hidden">
                        <div class="relative inline-block">
                            <img id="newImagePreview" class="w-32 h-32 object-cover rounded-lg border">
                            <button type="button" onclick="removeNewImage()"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <input type="file" name="icon_image" id="imageInput" accept="image/*" class="hidden">
                </div>

                <!-- Status -->
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible on website)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
            <button type="submit"
                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-lg transition">Update
                Category</button>
        </div>
    </form>

    <script>
        const uploadArea = document.getElementById('imageUploadArea');
        const imageInput = document.getElementById('imageInput');
        const newPreviewContainer = document.getElementById('newImagePreviewContainer');
        const newPreviewImg = document.getElementById('newImagePreview');
        const existingContainer = document.getElementById('existingImageContainer');
        let newImageFile = null;

        uploadArea.addEventListener('click', () => imageInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-yellow-500', 'bg-yellow-50');
        });

        uploadArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-yellow-500', 'bg-yellow-50');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-yellow-500', 'bg-yellow-50');

            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                handleNewImage(file);
            }
        });

        imageInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
                handleNewImage(e.target.files[0]);
            }
        });

        function handleNewImage(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                return;
            }

            newImageFile = file;
            const reader = new FileReader();
            reader.onload = (e) => {
                newPreviewImg.src = e.target.result;
                newPreviewContainer.classList.remove('hidden');
                uploadArea.classList.add('hidden');
                if (existingContainer) {
                    existingContainer.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        }

        function removeExistingImage() {
            if (existingContainer) {
                existingContainer.classList.add('hidden');
            }
            uploadArea.classList.remove('hidden');
            // Add hidden input to indicate existing image should be removed
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_icon';
            hiddenInput.value = '1';
            document.querySelector('form').appendChild(hiddenInput);
        }

        function removeNewImage() {
            newImageFile = null;
            imageInput.value = '';
            newPreviewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            if (existingContainer && existingContainer.classList.contains('hidden')) {
                existingContainer.classList.remove('hidden');
            }
        }
    </script>
@endsection

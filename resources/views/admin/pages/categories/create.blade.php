@extends('admin.layouts.app')

@section('title', 'Add Category')
@section('header', 'Add New Category')
@section('subheader', 'Create a new product category')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-[#D7B259] transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Categories
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">
                    <div>
                        <label class="form-label">Name (English) <span class="text-red-500">*</span></label>
                        <input type="text" name="name_en" value="{{ old('name_en') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-[#D7B259] focus:border-[#D7B259] @error('name_en') border-red-500 @enderror"
                            placeholder="Enter category name in English">
                        @error('name_en')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Name (Khmer) <span class="text-red-500">*</span></label>
                        <input type="text" name="name_kh" value="{{ old('name_kh') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-[#D7B259] focus:border-[#D7B259] @error('name_kh') border-red-500 @enderror"
                            placeholder="បញ្ចូលឈ្មោះប្រភេទជាភាសាខ្មែរ">
                        @error('name_kh')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Category Icon</label>
                        <div id="dropzone"
                            class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-[#D7B259] transition">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-600">Click or drag image here</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <div id="previewContainer" class="mt-4 hidden">
                            <div class="relative inline-block">
                                <img id="imagePreview" class="w-24 h-24 object-cover rounded-lg border">
                                <button type="button" onclick="removeImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" name="icon_image" id="imageInput" accept="image/*" class="hidden">
                        @error('icon_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Toggle Switch for Status -->
                    @include('admin.components.toggle-switch', [
                        'name' => 'is_active',
                        'checked' => old('is_active', true),
                        'label' => 'Category Status',
                        'helper' =>
                            'Enable this to show the category on your website. Disable to hide it temporarily.',
                    ])
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition">Create
                        Category</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropzone = document.getElementById('dropzone');
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('imagePreview');

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
                if (file && file.type.startsWith('image/')) handleImage(file);
            });
        }

        imageInput?.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) handleImage(e.target.files[0]);
        });

        function handleImage(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
                dropzone.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeImage() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            dropzone.classList.remove('hidden');
        }
    </script>
@endsection

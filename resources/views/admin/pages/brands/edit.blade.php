@extends('admin.layouts.app')

@section('title', 'Edit Brand')
@section('header', 'Edit Brand')
@section('subheader', 'Update brand information')

@section('content')
    <div class="max-w-2xl mx-auto pb-8 px-4 sm:px-0">
        <div class="mb-6">
            <a href="{{ route('admin.brands.index') }}"
                class="text-gray-600 hover:text-[#D7B259] transition inline-flex items-center gap-2 text-sm sm:text-base">
                <i class="fas fa-arrow-left text-xs sm:text-sm"></i> Back to Brands
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-4 sm:p-6 space-y-5 sm:space-y-6">
                    <!-- Name English -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name (English) <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <i
                                class="fas fa-language absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                            <input type="text" name="name_en" value="{{ old('name_en', $brand->name_en) }}" required
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-[#D7B259] focus:border-[#D7B259] @error('name_en') border-red-500 @enderror text-sm sm:text-base min-h-[42px]">
                        </div>
                        @error('name_en')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name Khmer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name (Khmer) <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <i
                                class="fas fa-language absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                            <input type="text" name="name_kh" value="{{ old('name_kh', $brand->name_kh) }}" required
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-[#D7B259] focus:border-[#D7B259] @error('name_kh') border-red-500 @enderror text-sm sm:text-base min-h-[42px]">
                        </div>
                        @error('name_kh')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Brand Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Brand Logo</label>

                        @if ($brand->logo_image)
                            <div id="existingImage" class="mb-4">
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $brand->logo_image) }}"
                                        class="w-24 h-24 object-cover rounded-lg border">
                                    <button type="button" onclick="removeExistingImage()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div id="dropzone"
                            class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-[#D7B259] transition {{ $brand->logo_image ? 'hidden' : '' }}">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-600">Click or drag new image here</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                        </div>

                        <div id="previewContainer" class="mt-4 hidden">
                            <div class="relative inline-block">
                                <img id="imagePreview" class="w-24 h-24 object-cover rounded-lg border">
                                <button type="button" onclick="removeNewImage()"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <input type="file" name="logo_image" id="imageInput" accept="image/*" class="hidden">
                        <input type="hidden" name="remove_logo" id="removeLogo" value="">
                        @error('logo_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status - Toggle Switch -->
                    <div class="pt-4 border-t border-gray-200">
                        @include('admin.components.toggle-switch', [
                            'name' => 'is_active',
                            'checked' => old('is_active', $brand->is_active),
                            'label' => 'Brand Status',
                            'helper' =>
                                'Enable this to show the brand on your website. Disable to hide it temporarily.',
                        ])
                    </div>
                </div>

                <div
                    class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('admin.brands.index') }}"
                        class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium text-center">
                        Cancel
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition font-medium">
                        <i class="fas fa-save mr-2"></i> Update Brand
                    </button>
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
        const removeLogo = document.getElementById('removeLogo');

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
                if (dropzone) dropzone.classList.add('hidden');
                if (existingImage) existingImage.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeExistingImage() {
            if (existingImage) existingImage.classList.add('hidden');
            if (dropzone) dropzone.classList.remove('hidden');
            if (removeLogo) removeLogo.value = '1';
        }

        function removeNewImage() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            if (dropzone) dropzone.classList.remove('hidden');
            if (existingImage && existingImage.classList.contains('hidden')) {
                existingImage.classList.remove('hidden');
            }
        }
    </script>
@endsection

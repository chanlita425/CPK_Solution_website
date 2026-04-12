@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('header', 'Edit Product')
@section('subheader', 'Update product information')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}"
                class="text-gray-600 hover:text-[#D7B259] transition inline-flex items-center gap-2">
                <i class="fas fa-arrow-left text-sm"></i> Back to Products
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category - Styled Select -->
                        <div>
                            @php
                                $categoryOptions = [];
                                foreach ($categories as $cat) {
                                    $categoryOptions[] = ['value' => $cat->id, 'label' => $cat->name_en];
                                }
                            @endphp
                            @include('admin.components.styled-select', [
                                'name' => 'category_id',
                                'options' => $categoryOptions,
                                'selected' => old('category_id', $product->category_id),
                                'label' => 'Category',
                                'required' => true,
                                'placeholder' => 'Select a category',
                                'icon' => 'fas fa-folder',
                            ])
                        </div>

                        <!-- Brand - Styled Select -->
                        <div>
                            @php
                                $brandOptions = [];
                                foreach ($brands as $brand) {
                                    $brandOptions[] = ['value' => $brand->id, 'label' => $brand->name_en];
                                }
                            @endphp
                            @include('admin.components.styled-select', [
                                'name' => 'brand_id',
                                'options' => $brandOptions,
                                'selected' => old('brand_id', $product->brand_id),
                                'label' => 'Brand',
                                'required' => true,
                                'placeholder' => 'Select a brand',
                                'icon' => 'fas fa-trademark',
                            ])
                        </div>

                        <!-- Name English -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name (English) <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-language absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}"
                                    required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('name_en') border-red-500 @enderror"
                                    placeholder="Enter product name in English">
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
                                <i class="fas fa-language absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="name_kh" value="{{ old('name_kh', $product->name_kh) }}"
                                    required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('name_kh') border-red-500 @enderror"
                                    placeholder="បញ្ចូលឈ្មោះផលិតផលជាភាសាខ្មែរ">
                            </div>
                            @error('name_kh')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SKU <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-barcode absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="SKU" value="{{ old('SKU', $product->SKU) }}" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('SKU') border-red-500 @enderror"
                                    placeholder="Unique product identifier">
                            </div>
                            @error('SKU')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    step="0.01" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('price') border-red-500 @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specification English -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specification (English)</label>
                            <textarea name="specification_en" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('specification_en') border-red-500 @enderror"
                                placeholder="Enter product specifications in English...">{{ old('specification_en', $product->specification_en) }}</textarea>
                            @error('specification_en')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specification Khmer -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specification (Khmer)</label>
                            <textarea name="specification_kh" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('specification_kh') border-red-500 @enderror"
                                placeholder="បញ្ចូលព័ត៌មានលម្អិតផលិតផលជាភាសាខ្មែរ...">{{ old('specification_kh', $product->specification_kh) }}</textarea>
                            @error('specification_kh')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Images -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Images <span
                                    class="text-gray-400 text-xs font-normal">(Max 4 images)</span></label>

                            <!-- Existing Images -->
                            @if ($product->images && $product->images->count() > 0)
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 mb-2">Current Images</label>
                                    <div id="existingImages" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($product->images as $image)
                                            <div class="relative group" data-image-id="{{ $image->id }}">
                                                <img src="{{ asset('storage/' . $image->image) }}"
                                                    class="w-full h-32 object-cover rounded-lg border">
                                                <button type="button" onclick="markForDeletion({{ $image->id }}, this)"
                                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition opacity-0 group-hover:opacity-100">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                                @if ($loop->first)
                                                    <div
                                                        class="absolute bottom-2 left-2 bg-[#D7B259] text-white text-xs px-2 py-0.5 rounded">
                                                        Main</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Click the X button on any image to mark it for
                                        deletion</p>
                                </div>
                            @endif

                            <!-- New Images Upload -->
                            <div id="dropzone"
                                class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-[#D7B259] transition">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                                <p class="text-gray-600">Click or drag new images here</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB each (Max 4 images total)</p>
                            </div>
                            <div id="newImagesContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*"
                                class="hidden">
                            <input type="hidden" name="deleted_images" id="deletedImages" value="">
                            <p class="text-xs text-gray-500 mt-2">First image will be used as main product image</p>
                            @error('images.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status - Toggle Switch -->
                        <div class="md:col-span-2 pt-4 border-t border-gray-200">
                            @include('admin.components.toggle-switch', [
                                'name' => 'is_active',
                                'checked' => old('is_active', $product->is_active),
                                'label' => 'Product Status',
                                'helper' => 'Enable this to show the product on your website. Disable to hide it temporarily.',
                            ])
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let deletedImageIds = [];
        let selectedFiles = [];
        const existingContainer = document.getElementById('existingImages');
        const newContainer = document.getElementById('newImagesContainer');
        const dropzone = document.getElementById('dropzone');
        const imageInput = document.getElementById('imageInput');
        const deletedImagesInput = document.getElementById('deletedImages');

        function markForDeletion(imageId, buttonElement) {
            if (!deletedImageIds.includes(imageId)) {
                deletedImageIds.push(imageId);
                const container = buttonElement.closest('.relative');
                container.style.opacity = '0.4';
                container.style.filter = 'grayscale(1)';
                buttonElement.style.opacity = '1';
                buttonElement.style.display = 'flex';
                deletedImagesInput.value = deletedImageIds.join(',');
                showToast('Image marked for deletion', 'warning');
            }
        }

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
                const files = Array.from(e.dataTransfer.files);
                handleFiles(files);
            });
        }

        imageInput?.addEventListener('change', (e) => {
            handleFiles(Array.from(e.target.files));
        });

        function handleFiles(files) {
            const existingCount = {{ $product->images->count() }} - deletedImageIds.length;
            const remainingSlots = 4 - (existingCount + selectedFiles.length);
            const validFiles = files.filter(file => file.type.startsWith('image/'));

            if (validFiles.length > remainingSlots) {
                showToast(`Maximum ${remainingSlots} more image(s) allowed`, 'error');
                return;
            }

            validFiles.forEach(file => {
                if (file.size > 2 * 1024 * 1024) {
                    showToast(`Image ${file.name} exceeds 2MB limit`, 'error');
                    return;
                }
                selectedFiles.push(file);
                displayPreview(file);
            });
            updateDataTransfer();
        }

        function displayPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const container = document.createElement('div');
                container.className = 'relative group';
                container.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border">
                    <button type="button" onclick="removeNewImage('${file.name}')"
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                    <div class="absolute bottom-2 left-2 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded">New</div>
                `;
                newContainer.appendChild(container);
            };
            reader.readAsDataURL(file);
        }

        function removeNewImage(fileName) {
            selectedFiles = selectedFiles.filter(f => f.name !== fileName);
            const containers = newContainer.children;
            for (let i = 0; i < containers.length; i++) {
                const btn = containers[i].querySelector('button');
                if (btn && btn.getAttribute('onclick') === `removeNewImage('${fileName}')`) {
                    containers[i].remove();
                    break;
                }
            }
            updateDataTransfer();
        }

        function updateDataTransfer() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
        }
    </script>
@endsection

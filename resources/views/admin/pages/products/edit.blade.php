{{-- resources/views/admin/products/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-yellow-600">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
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

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow-sm overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category <span
                            class="text-red-500">*</span></label>
                    <select name="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand <span
                            class="text-red-500">*</span></label>
                    <select name="brand_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">Select Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Name English -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name (English) <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <!-- Name Khmer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name (Khmer) <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name_kh" value="{{ old('name_kh', $product->name_kh) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SKU <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="SKU" value="{{ old('SKU', $product->SKU) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                    <p class="text-xs text-gray-500 mt-1">Unique product identifier</p>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01"
                            required
                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-500">
                        <span class="ml-2 text-sm text-gray-600">Active (visible on website)</span>
                    </label>
                </div>

                <!-- Specification English -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specification (English)</label>
                    <textarea name="specification_en" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">{{ old('specification_en', $product->specification_en) }}</textarea>
                </div>

                <!-- Specification Khmer -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specification (Khmer)</label>
                    <textarea name="specification_kh" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">{{ old('specification_kh', $product->specification_kh) }}</textarea>
                </div>

                <!-- Product Images -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Images (Max 4)</label>

                    <!-- Existing Images -->
                    <div id="existingImagesContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        @foreach ($product->images as $image)
                            <div class="relative group" data-image-id="{{ $image->id }}">
                                <img src="{{ asset('storage/' . $image->image) }}"
                                    class="w-full h-32 object-cover rounded-lg">
                                <button type="button" onclick="markForDeletion({{ $image->id }}, this)"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- New Images Upload -->
                    <div id="imageUploadArea"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-yellow-500 transition">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                        <p class="text-gray-600">Click or drag images here</p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB each (Max 4 images total)</p>
                    </div>
                    <div id="newImagesContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
                    <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="hidden">
                    <input type="hidden" name="deleted_images" id="deletedImages" value="">
                    <p class="text-xs text-gray-500 mt-2">First image will be used as main product image</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
            <button type="submit"
                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-lg transition">Update
                Product</button>
        </div>
    </form>

    <script>
        let selectedFiles = [];
        let deletedImageIds = [];
        const existingContainer = document.getElementById('existingImagesContainer');
        const newContainer = document.getElementById('newImagesContainer');
        const imageUploadArea = document.getElementById('imageUploadArea');
        const imageInput = document.getElementById('imageInput');
        const deletedImagesInput = document.getElementById('deletedImages');

        function markForDeletion(imageId, buttonElement) {
            if (!deletedImageIds.includes(imageId)) {
                deletedImageIds.push(imageId);
                const container = buttonElement.closest('.relative');
                container.style.opacity = '0.5';
                container.style.filter = 'grayscale(1)';
                buttonElement.style.display = 'none';
                deletedImagesInput.value = deletedImageIds.join(',');
            }
        }

        imageUploadArea.addEventListener('click', () => imageInput.click());

        imageUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadArea.classList.add('border-yellow-500', 'bg-yellow-50');
        });

        imageUploadArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            imageUploadArea.classList.remove('border-yellow-500', 'bg-yellow-50');
        });

        imageUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadArea.classList.remove('border-yellow-500', 'bg-yellow-50');

            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        imageInput.addEventListener('change', (e) => {
            handleFiles(Array.from(e.target.files));
        });

        function handleFiles(files) {
            const existingCount = {{ $product->images->count() }} - deletedImageIds.length;
            const remainingSlots = 4 - (existingCount + selectedFiles.length);
            const validFiles = files.filter(file => file.type.startsWith('image/'));

            if (validFiles.length > remainingSlots) {
                alert(`Maximum ${remainingSlots} more image${remainingSlots !== 1 ? 's' : ''} allowed`);
                return;
            }

            validFiles.forEach(file => {
                if (file.size > 2 * 1024 * 1024) {
                    alert(`Image ${file.name} exceeds 2MB limit`);
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
            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
            <button type="button" onclick="removeNewImage('${file.name}')" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                <i class="fas fa-times text-xs"></i>
            </button>
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg"></div>
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

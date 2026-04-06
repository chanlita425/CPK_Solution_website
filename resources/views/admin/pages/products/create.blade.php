@extends('admin.layouts.app')

@section('title', 'Add Product')
@section('header', 'Add New Product')
@section('subheader', 'Create a new product')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-[#D7B259] transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                'selected' => old('category_id'),
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
                                'selected' => old('brand_id'),
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
                                <i class="fas fa-language absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="name_en" value="{{ old('name_en') }}" required
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
                                <i class="fas fa-language absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="name_kh" value="{{ old('name_kh') }}" required
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
                                <i class="fas fa-barcode absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="SKU" value="{{ old('SKU') }}" required
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
                                <i class="fas fa-dollar-sign absolute left-3 top-3 text-gray-400"></i>
                                <input type="number" name="price" value="{{ old('price') }}" step="0.01" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('price') border-red-500 @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-boxes absolute left-3 top-3 text-gray-400"></i>
                                <input type="number" name="quantity" value="{{ old('quantity', 0) }}" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('quantity') border-red-500 @enderror"
                                    placeholder="Stock quantity">
                            </div>
                            @error('quantity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specification English -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specification (English)</label>
                            <textarea name="specification_en" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('specification_en') border-red-500 @enderror"
                                placeholder="Enter product specifications in English...">{{ old('specification_en') }}</textarea>
                            @error('specification_en')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specification Khmer -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specification (Khmer)</label>
                            <textarea name="specification_kh" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent @error('specification_kh') border-red-500 @enderror"
                                placeholder="បញ្ចូលព័ត៌មានលម្អិតផលិតផលជាភាសាខ្មែរ...">{{ old('specification_kh') }}</textarea>
                            @error('specification_kh')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Images -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Images <span
                                    class="text-gray-400 text-xs font-normal">(Max 4 images)</span></label>
                            <div id="dropzone"
                                class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-[#D7B259] transition">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2 block"></i>
                                <p class="text-gray-600">Click or drag images here</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB each</p>
                            </div>
                            <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="hidden">
                            <p class="text-xs text-gray-500 mt-2">First image will be used as main product image</p>
                            @error('images.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status - Toggle Switch -->
                        <div class="md:col-span-2 pt-4 border-t border-gray-200">
                            @include('admin.components.toggle-switch', [
                                'name' => 'is_active',
                                'checked' => old('is_active', true),
                                'label' => 'Product Status',
                                'helper' =>
                                    'Enable this to show the product on your website. Disable to hide it temporarily.',
                            ])
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i> Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image upload script -->
    <script>
        const dropzone = document.getElementById('dropzone');
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        let selectedFiles = [];

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
                handleFiles(Array.from(e.dataTransfer.files));
            });
        }

        imageInput?.addEventListener('change', (e) => {
            handleFiles(Array.from(e.target.files));
        });

        function handleFiles(files) {
            const remainingSlots = 4 - selectedFiles.length;
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
            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
            <button type="button" onclick="removeImage('${file.name}')"
                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                <i class="fas fa-times text-xs"></i>
            </button>
        `;
                previewContainer.appendChild(container);
            };
            reader.readAsDataURL(file);
        }

        function removeImage(fileName) {
            selectedFiles = selectedFiles.filter(f => f.name !== fileName);
            const containers = previewContainer.children;
            for (let i = 0; i < containers.length; i++) {
                const btn = containers[i].querySelector('button');
                if (btn && btn.getAttribute('onclick') === `removeImage('${fileName}')`) {
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

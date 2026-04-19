@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')

@section('content')

    {{-- ----------- Title Category ---------- --}}
    <div id="product-grid" style="scroll-margin-top: 80px;"></div>
    <div class="relative px-4 sm:px-8 lg:px-14 mt-24 mb-4 flex items-center justify-center">

        <h2 id="category-title" class="text-[20px] font-bold text-[#D7B259] text-center">
            {{ $categoryName }}
        </h2>

        <span id="items-count"
            class="absolute right-4 sm:right-8 lg:right-14 px-5 py-1.5 rounded-full text-sm font-bold text-white shadow"
            style="background:#D7B259;">
            {{ number_format($products->total()) }} {{ __('messages.items') }}
        </span>
    </div>

    {{-- Products Container (will be updated via AJAX) --}}
    <div id="products-container">
        @include('frontend.components.product-grid', [
            'products' => $products,
            'isHome' => true,
            'promoImage' => $promoImage,
            'categoryId' => $categoryId,
            'brandId' => $brandId,
        ])
    </div>

    {{-- Pagination Container --}}
    <div id="pagination-container" class="mt-6">
        @if ($products->hasPages() && $products->count() > 0)
            @include('frontend.components.pagination', [
                'page' => $products->currentPage(),
                'total' => $products->lastPage(),
                'size' => 'lg',
                'ajax' => true,
            ])
        @endif
    </div>

    {{-- No Results Modal --}}
    <div id="noResultsModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-6 max-w-sm mx-4 text-center">
            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-amber-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('messages.no_products_found') }}</h3>
            <p class="text-gray-500 text-sm mb-4" id="noResultsMessage">{{ __('messages.try_adjusting_filters') }}</p>
            <button onclick="closeNoResultsModal()"
                class="px-4 py-2 bg-[#D7B259] text-white rounded-lg hover:bg-[#c4a145] transition">
                {{ __('messages.got_it') }}
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Store current filters
        let currentFilters = {
            category_id: {{ $categoryId ?? 'null' }},
            brand_id: {{ $brandId ?? 'null' }},
            search: '{{ $searchQuery ?? '' }}',
            page: {{ $products->currentPage() }}
        };

        let isLoading = false;

        // Translations for JavaScript
        const translations = {
            items: '{{ __('messages.items') }}',
            no_products_found: '{{ __('messages.no_products_found') }}',
            try_adjusting_filters: '{{ __('messages.try_adjusting_filters') }}',
            reset_filters: '{{ __('messages.reset_filters') }}',
            all_products: '{{ __('messages.all_products') }}',
            got_it: '{{ __('messages.got_it') }}'
        };

        // Function to load products via AJAX
        function loadProducts() {
            if (isLoading) return;

            isLoading = true;

            // Show loading indicator
            const container = document.getElementById('products-container');
            if (container) {
                container.style.opacity = '0.5';
            }

            // Build query string
            const params = new URLSearchParams();
            if (currentFilters.category_id) params.append('category_id', currentFilters.category_id);
            if (currentFilters.brand_id) params.append('brand_id', currentFilters.brand_id);
            if (currentFilters.search) params.append('search', currentFilters.search);
            params.append('page', currentFilters.page);

            fetch('{{ route('home') }}?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update products container
                        if (container) {
                            if (data.products_html && data.products_html.trim() !== '') {
                                container.innerHTML = data.products_html;
                            } else {
                                container.innerHTML = `
                                    <div class="text-center py-16 px-4">
                                        <i class="fas fa-box-open text-6xl text-gray-300 mb-4 block"></i>
                                        <p class="text-gray-500 text-lg mb-2">${translations.no_products_found}</p>
                                        <p class="text-gray-400 text-sm">${translations.try_adjusting_filters}</p>
                                        <button onclick="resetAllFilters()" class="mt-4 px-6 py-2 bg-[#D7B259] text-white rounded-full hover:bg-[#c4a145] transition">
                                            <i class="fas fa-undo-alt mr-2"></i> ${translations.reset_filters}
                                        </button>
                                    </div>
                                `;
                            }
                            container.style.opacity = '1';
                        }

                        // Update pagination - ONLY if there is pagination HTML and total pages > 1
                        const paginationContainer = document.getElementById('pagination-container');
                        if (paginationContainer) {
                            if (data.pagination_html && data.pagination_html !== '') {
                                paginationContainer.innerHTML = data.pagination_html;
                                paginationContainer.style.display = 'block';
                            } else {
                                paginationContainer.innerHTML = '';
                                paginationContainer.style.display = 'none';
                            }
                        }

                        // Update items count
                        const itemsCount = document.getElementById('items-count');
                        if (itemsCount && data.total !== undefined) {
                            itemsCount.textContent = data.total + ' ' + translations.items;
                        }

                        // Update URL without page reload
                        const newUrl = new URL(window.location.href);
                        if (currentFilters.category_id) {
                            newUrl.searchParams.set('category_id', currentFilters.category_id);
                        } else {
                            newUrl.searchParams.delete('category_id');
                        }
                        if (currentFilters.brand_id) {
                            newUrl.searchParams.set('brand_id', currentFilters.brand_id);
                        } else {
                            newUrl.searchParams.delete('brand_id');
                        }
                        if (currentFilters.search) {
                            newUrl.searchParams.set('search', currentFilters.search);
                        } else {
                            newUrl.searchParams.delete('search');
                        }
                        newUrl.searchParams.set('page', currentFilters.page);
                        window.history.pushState({}, '', newUrl);
                    }
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    if (container) {
                        container.style.opacity = '1';
                    }
                })
                .finally(() => {
                    isLoading = false;
                });
        }

        // Reset all filters
        function resetAllFilters() {
            currentFilters = {
                category_id: null,
                brand_id: null,
                search: '',
                page: 1
            };

            // Update UI active states
            document.querySelectorAll('.category-filter-link').forEach(link => {
                link.classList.remove('bg-[#FFE3A1]', 'shadow-sm');
            });
            document.querySelectorAll('.brand-filter-link').forEach(link => {
                link.classList.remove('bg-[#FFE3A1]');
            });

            // Clear search input
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) searchInput.value = '';
            const navbarSearch = document.getElementById('live-search-input');
            if (navbarSearch) navbarSearch.value = '';

            // Update category title
            const titleEl = document.getElementById('category-title');
            if (titleEl) titleEl.textContent = translations.all_products;

            // Load products
            loadProducts();
        }

        function closeNoResultsModal() {
            const modal = document.getElementById('noResultsModal');
            if (modal) modal.classList.add('hidden');
        }

        // Category filter handler - supports unclick/unfilter
        document.querySelectorAll('.category-filter-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryId = this.dataset.categoryId;

                // Check if clicking the same category that is already active -> unfilter
                const isCurrentlyActive = this.classList.contains('bg-[#FFE3A1]');

                if (isCurrentlyActive && categoryId === String(currentFilters.category_id)) {
                    // Remove filter - unclick
                    currentFilters.category_id = null;
                    this.classList.remove('bg-[#FFE3A1]', 'shadow-sm');

                    // Update category title to "All Products"
                    const titleEl = document.getElementById('category-title');
                    if (titleEl) titleEl.textContent = translations.all_products;
                } else {
                    // Remove active from all, then add to this one
                    document.querySelectorAll('.category-filter-link').forEach(l => {
                        l.classList.remove('bg-[#FFE3A1]', 'shadow-sm');
                    });
                    this.classList.add('bg-[#FFE3A1]', 'shadow-sm');
                    currentFilters.category_id = categoryId ? parseInt(categoryId) : null;

                    // Update category title
                    const categoryName = this.querySelector('span:last-child')?.innerText ||
                        this.querySelector('.text-\\[10px\\]')?.innerText ||
                        'Category';
                    const titleEl = document.getElementById('category-title');
                    if (titleEl) titleEl.textContent = categoryName;
                }

                currentFilters.page = 1;
                loadProducts();
            });
        });

        // Brand filter handler - supports unclick/unfilter
        document.querySelectorAll('.brand-filter-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const brandId = this.dataset.brandId;

                // Check if clicking the same brand that is already active -> unfilter
                const isCurrentlyActive = this.classList.contains('bg-[#FFE3A1]');

                if (isCurrentlyActive && brandId === String(currentFilters.brand_id)) {
                    // Remove filter - unclick
                    currentFilters.brand_id = null;
                    this.classList.remove('bg-[#FFE3A1]');
                } else {
                    // Remove active from all, then add to this one
                    document.querySelectorAll('.brand-filter-link').forEach(l => {
                        l.classList.remove('bg-[#FFE3A1]');
                    });
                    this.classList.add('bg-[#FFE3A1]');
                    currentFilters.brand_id = brandId ? parseInt(brandId) : null;
                }

                currentFilters.page = 1;
                loadProducts();
            });
        });

        // Search form handler
        const searchForm = document.querySelector('form[action=""]');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchInput = this.querySelector('input[name="search"]');
                if (searchInput) {
                    currentFilters.search = searchInput.value;
                    currentFilters.page = 1;
                    loadProducts();
                }
            });
        }

        // Navbar search handler
        const navbarSearchInput = document.getElementById('live-search-input');
        if (navbarSearchInput) {
            navbarSearchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    currentFilters.search = this.value;
                    currentFilters.page = 1;
                    loadProducts();
                    const dropdown = document.getElementById('live-search-dropdown');
                    if (dropdown) dropdown.classList.add('hidden');
                }
            });
        }

        // Pagination handler using event delegation
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.pagination-ajax-btn');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();

                const page = parseInt(btn.getAttribute('data-page'));
                if (!isNaN(page) && page !== currentFilters.page) {
                    currentFilters.page = page;
                    loadProducts();
                    // Scroll to top of products
                    const productGrid = document.getElementById('product-grid');
                    if (productGrid) {
                        productGrid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            currentFilters.category_id = urlParams.get('category_id') ? parseInt(urlParams.get('category_id')) :
                null;
            currentFilters.brand_id = urlParams.get('brand_id') ? parseInt(urlParams.get('brand_id')) : null;
            currentFilters.search = urlParams.get('search') || '';
            currentFilters.page = parseInt(urlParams.get('page')) || 1;

            // Update active states for categories
            if (currentFilters.category_id) {
                document.querySelectorAll('.category-filter-link').forEach(link => {
                    if (parseInt(link.dataset.categoryId) === currentFilters.category_id) {
                        link.classList.add('bg-[#FFE3A1]', 'shadow-sm');
                        const categoryName = link.querySelector('span:last-child')?.innerText || 'Category';
                        const titleEl = document.getElementById('category-title');
                        if (titleEl) titleEl.textContent = categoryName;
                    } else {
                        link.classList.remove('bg-[#FFE3A1]', 'shadow-sm');
                    }
                });
            } else {
                document.querySelectorAll('.category-filter-link').forEach(link => {
                    link.classList.remove('bg-[#FFE3A1]', 'shadow-sm');
                });
                const titleEl = document.getElementById('category-title');
                if (titleEl) titleEl.textContent = translations.all_products;
            }

            // Update active states for brands
            if (currentFilters.brand_id) {
                document.querySelectorAll('.brand-filter-link').forEach(link => {
                    if (parseInt(link.dataset.brandId) === currentFilters.brand_id) {
                        link.classList.add('bg-[#FFE3A1]');
                    } else {
                        link.classList.remove('bg-[#FFE3A1]');
                    }
                });
            } else {
                document.querySelectorAll('.brand-filter-link').forEach(link => {
                    link.classList.remove('bg-[#FFE3A1]');
                });
            }

            // Update search input
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) searchInput.value = currentFilters.search;
            const navbarSearch = document.getElementById('live-search-input');
            if (navbarSearch) navbarSearch.value = currentFilters.search;

            loadProducts();
        });

        // Close modal when clicking outside
        document.getElementById('noResultsModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeNoResultsModal();
            }
        });
    </script>
@endpush

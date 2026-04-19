@php
    $settings = \App\Models\Setting::getSettings();
    $logoPath = $settings->company_logo;
@endphp

<nav class="nav mt-2">
    <div class="max-w-7xl mx-auto px-10 sm:px-12 lg:px-12">
        <div class="flex items-center justify-between h-20 gap-4">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <div class="rounded-lg flex items-center justify-center">
                    @if($logoPath && Storage::disk('public')->exists($logoPath))
                        <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $settings->company_name ?? 'CPK' }}" class="h-10">
                    @else
                        <span class="text-lg font-bold">{{ $settings->company_name ?? 'CPK' }}</span>
                    @endif
                </div>
            </a>

            {{-- Search Bar with Live Dropdown --}}
            <div class="flex-1 max-w-xl hidden sm:block relative">
                <div class="relative">
                    <input
                        type="text"
                        id="live-search-input"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('messages.search_products') }}..."
                        class="w-full border border-gray-400 bg-gray-50 rounded-[18px] py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
                        autocomplete="off"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition-colors">
                        <i class="fa fa-search text-sm"></i>
                    </button>
                </div>

                {{-- Live Search Dropdown --}}
                <div id="live-search-dropdown" class="absolute top-full left-0 right-0 mt-1 bg-white rounded-xl shadow-xl border border-gray-200 z-50 hidden max-h-96 overflow-y-auto">
                    <div class="p-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs text-gray-500">{{ __('messages.products') }}</p>
                    </div>
                    <div id="live-search-results" class="divide-y divide-gray-100">
                        {{-- Results will be inserted here --}}
                    </div>
                    <div id="live-search-loading" class="p-4 text-center text-gray-400 hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i> {{ __('messages.searching') }}...
                    </div>
                    <div id="live-search-empty" class="p-4 text-center text-gray-400 hidden">
                        <i class="fas fa-search text-2xl mb-2 block"></i>
                        <p>{{ __('messages.no_products_found') }}</p>
                    </div>
                </div>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-4">
                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1.5 text-gray-600 hover:text-primary-600 transition-colors group">
                    <div class="relative">
                        <i class="fa-solid fa-bag-shopping text-[#28282A] text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <span class="hidden md:inline text-sm font-medium text-[#28282A] ml-1">{{ __('messages.cart') }}</span>

                    @php $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0; @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center animate-pulse-badge">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Mobile search toggle --}}
                <button class="sm:hidden text-gray-500 hover:text-primary-500" id="mobileSearchBtn">
                    <i class="fa fa-search text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Search with Dropdown --}}
        <div class="sm:hidden pb-3 hidden relative" id="mobileSearch">
            <div class="relative">
                <input
                    type="text"
                    id="mobile-search-input"
                    name="q"
                    placeholder="{{ __('messages.search_products') }}..."
                    class="w-full border border-gray-200 bg-gray-50 rounded-full py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                    autocomplete="off"
                >
                <button id="mobile-search-submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search text-sm"></i>
                </button>
            </div>

            {{-- Mobile Live Search Dropdown --}}
            <div id="mobile-search-dropdown" class="absolute top-full left-0 right-0 mt-1 bg-white rounded-xl shadow-xl border border-gray-200 z-50 hidden max-h-80 overflow-y-auto">
                <div class="p-3 border-b border-gray-100 bg-gray-50">
                    <p class="text-xs text-gray-500">{{ __('messages.products') }}</p>
                </div>
                <div id="mobile-search-results" class="divide-y divide-gray-100">
                    {{-- Results will be inserted here --}}
                </div>
                <div id="mobile-search-loading" class="p-4 text-center text-gray-400 hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i> {{ __('messages.searching') }}...
                </div>
                <div id="mobile-search-empty" class="p-4 text-center text-gray-400 hidden">
                    <i class="fas fa-search text-2xl mb-2 block"></i>
                    <p>{{ __('messages.no_products_found') }}</p>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Desktop Live Search Functionality
    const searchInput = document.getElementById('live-search-input');
    const dropdown = document.getElementById('live-search-dropdown');
    const resultsContainer = document.getElementById('live-search-results');
    const loadingDiv = document.getElementById('live-search-loading');
    const emptyDiv = document.getElementById('live-search-empty');

    // Mobile Search Elements
    const mobileSearchContainer = document.getElementById('mobileSearch');
    const mobileSearchInput = document.getElementById('mobile-search-input');
    const mobileDropdown = document.getElementById('mobile-search-dropdown');
    const mobileResultsContainer = document.getElementById('mobile-search-results');
    const mobileLoadingDiv = document.getElementById('mobile-search-loading');
    const mobileEmptyDiv = document.getElementById('mobile-search-empty');
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    const mobileSearchSubmit = document.getElementById('mobile-search-submit');

    let debounceTimer;
    let currentRequest = null;
    let mobileDebounceTimer;
    let mobileCurrentRequest = null;

    // Desktop search functions
    function showDropdown() {
        dropdown.classList.remove('hidden');
    }

    function hideDropdown() {
        dropdown.classList.add('hidden');
    }

    function performLiveSearch(query) {
        if (!query || query.length < 2) {
            resultsContainer.innerHTML = '';
            loadingDiv.classList.add('hidden');
            emptyDiv.classList.add('hidden');
            hideDropdown();
            return;
        }

        if (currentRequest) {
            currentRequest.abort();
        }

        showDropdown();
        loadingDiv.classList.remove('hidden');
        emptyDiv.classList.add('hidden');
        resultsContainer.innerHTML = '';

        currentRequest = new AbortController();

        fetch('{{ route("live.search") }}?q=' + encodeURIComponent(query), {
            signal: currentRequest.signal
        })
        .then(response => response.json())
        .then(data => {
            loadingDiv.classList.add('hidden');

            if (data.success && data.results && data.results.length > 0) {
                resultsContainer.innerHTML = data.results.map(product => `
                    <a href="${product.url}" class="flex items-center gap-3 p-3 hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            ${product.image_url ?
                                `<img src="${product.image_url}" alt="${product.name_en}" class="w-full h-full object-cover">` :
                                `<i class="fas fa-box text-gray-300 text-2xl flex items-center justify-center h-full"></i>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">${escapeHtml(product.name)}</p>
                            <p class="text-xs text-gray-500">{{ __('messages.sku') }}: ${escapeHtml(product.SKU)}</p>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>${product.category_name ? escapeHtml(product.category_name) : '{{ __("messages.no_category") }}'}</span>
                                <span>•</span>
                                <span>${product.brand_name ? escapeHtml(product.brand_name) : '{{ __("messages.no_brand") }}'}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-[#C9A84C]">$${product.price_formatted}</p>
                        </div>
                    </a>
                `).join('');
                emptyDiv.classList.add('hidden');
            } else {
                emptyDiv.classList.remove('hidden');
                resultsContainer.innerHTML = '';
            }
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Search error:', error);
                loadingDiv.classList.add('hidden');
                emptyDiv.classList.remove('hidden');
            }
        });
    }

    // Mobile search functions
    function showMobileDropdown() {
        mobileDropdown.classList.remove('hidden');
    }

    function hideMobileDropdown() {
        mobileDropdown.classList.add('hidden');
    }

    function performMobileSearch(query) {
        if (!query || query.length < 2) {
            mobileResultsContainer.innerHTML = '';
            mobileLoadingDiv.classList.add('hidden');
            mobileEmptyDiv.classList.add('hidden');
            hideMobileDropdown();
            return;
        }

        if (mobileCurrentRequest) {
            mobileCurrentRequest.abort();
        }

        showMobileDropdown();
        mobileLoadingDiv.classList.remove('hidden');
        mobileEmptyDiv.classList.add('hidden');
        mobileResultsContainer.innerHTML = '';

        mobileCurrentRequest = new AbortController();

        fetch('{{ route("live.search") }}?q=' + encodeURIComponent(query), {
            signal: mobileCurrentRequest.signal
        })
        .then(response => response.json())
        .then(data => {
            mobileLoadingDiv.classList.add('hidden');

            if (data.success && data.results && data.results.length > 0) {
                mobileResultsContainer.innerHTML = data.results.map(product => `
                    <a href="${product.url}" class="flex items-center gap-3 p-3 hover:bg-gray-50 transition-colors">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            ${product.image_url ?
                                `<img src="${product.image_url}" alt="${product.name_en}" class="w-full h-full object-cover">` :
                                `<i class="fas fa-box text-gray-300 text-lg flex items-center justify-center h-full"></i>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">${escapeHtml(product.name)}</p>
                            <p class="text-xs text-gray-500">{{ __('messages.sku') }}: ${escapeHtml(product.SKU)}</p>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>${product.category_name ? escapeHtml(product.category_name) : '{{ __("messages.no_category") }}'}</span>
                                <span>•</span>
                                <span>${product.brand_name ? escapeHtml(product.brand_name) : '{{ __("messages.no_brand") }}'}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-[#C9A84C]">$${product.price_formatted}</p>
                        </div>
                    </a>
                `).join('');
                mobileEmptyDiv.classList.add('hidden');
            } else {
                mobileEmptyDiv.classList.remove('hidden');
                mobileResultsContainer.innerHTML = '';
            }
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Search error:', error);
                mobileLoadingDiv.classList.add('hidden');
                mobileEmptyDiv.classList.remove('hidden');
            }
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // Desktop search event handlers
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            const query = e.target.value.trim();
            debounceTimer = setTimeout(() => performLiveSearch(query), 300);
        });

        searchInput.addEventListener('focus', function() {
            if (searchInput.value.trim().length >= 2 && resultsContainer.children.length > 0) {
                showDropdown();
            }
        });
    }

    // Mobile search event handlers
    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('input', function(e) {
            clearTimeout(mobileDebounceTimer);
            const query = e.target.value.trim();
            mobileDebounceTimer = setTimeout(() => performMobileSearch(query), 300);
        });

        mobileSearchInput.addEventListener('focus', function() {
            if (mobileSearchInput.value.trim().length >= 2 && mobileResultsContainer.children.length > 0) {
                showMobileDropdown();
            }
        });
    }

    if (mobileSearchSubmit) {
        mobileSearchSubmit.addEventListener('click', function(e) {
            e.preventDefault();
            const query = mobileSearchInput.value.trim();
            if (query && query.length >= 2) {
                performMobileSearch(query);
            }
        });
    }

    // Mobile search toggle
    const mobileSearchBtnElement = document.getElementById('mobileSearchBtn');
    if (mobileSearchBtnElement) {
        mobileSearchBtnElement.addEventListener('click', () => {
            const mobileSearchDiv = document.getElementById('mobileSearch');
            mobileSearchDiv.classList.toggle('hidden');
            if (!mobileSearchDiv.classList.contains('hidden')) {
                mobileSearchInput.focus();
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput?.contains(e.target) && !dropdown?.contains(e.target)) {
            hideDropdown();
        }
        if (!mobileSearchInput?.contains(e.target) && !mobileDropdown?.contains(e.target)) {
            hideMobileDropdown();
        }
    });
</script>

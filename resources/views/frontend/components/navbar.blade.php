@php
    $settings = \App\Models\Setting::getSettings();
    $logoPath = $settings->company_logo;
    $navCategories = \App\Models\Category::where('is_active', true)->get();
@endphp

{{-- resources/views/components/navbar.blade.php --}}
<nav class="nav mt-2">
    <div class="max-w-7xl mx-auto px-10 sm:px-12 lg:px-12">
        <div class="flex items-center justify-between h-20 gap-4">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <div class="rounded-lg flex items-center justify-center ">
                    @if($logoPath)
                        <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $settings->company_name }}" class="h-10">
                    @else
                        <span class="text-lg font-bold">{{ $settings->company_name ?? 'CPK' }}</span>
                    @endif
                </div>
            </a>

            {{-- Search Bar --}}
            <div class="flex-1 max-w-xl hidden sm:block relative" id="searchWrapper">
                <form id="searchForm" action="{{ route('home') }}" method="GET" class="relative" autocomplete="off">
                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        value=""
                        placeholder="{{ __('messages.search_placeholder') }}"
                        class="w-full border border-gray-400 bg-gray-50 rounded-[18px] py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition"
                        oninput="handleSearchInput(this.value)"
                        onfocus="handleSearchInput(this.value)"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition-colors">
                        <i class="fa fa-search text-sm"></i>
                    </button>
                </form>

                {{-- Search Dropdown --}}
                <div id="searchDropdown"
                    class="absolute left-0 right-0 top-full mt-1 bg-white rounded-2xl shadow-lg border border-gray-100 z-50 hidden max-h-96 overflow-y-auto">

                    {{-- Product name suggestions (AJAX) --}}
                    <div id="productSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">{{ __('messages.products') }}</p>
                        <ul id="productList"></ul>
                    </div>

                    {{-- Brand suggestions (AJAX) --}}
                    <div id="brandSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">{{ __('messages.brands') }}</p>
                        <ul id="brandList"></ul>
                    </div>

                    {{-- SKU suggestions (AJAX) --}}
                    <div id="skuSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-1 pb-1">{{ __('messages.sku') }}</p>
                        <ul id="skuList"></ul>
                    </div>

                    {{-- Categories (client-side filter) --}}
                    <div id="categorySection">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">{{ __('messages.categories') }}</p>
                        <ul id="categoryList">
                            @foreach($navCategories as $cat)
                            <li class="category-item"
                                data-name="{{ strtolower($cat->name_en ?? '') }}"
                                data-name-kh="{{ $cat->name_kh ?? '' }}">
                                <a href="{{ route('home') }}?category_id={{ $cat->id }}#product-grid"
                                    data-filter-link="category"
                                    data-cat-id="{{ $cat->id }}"
                                    class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-sm text-gray-700">
                                    @if($cat->icon_url)
                                        <img src="{{ asset($cat->icon_url) }}" class="w-6 h-6 object-contain">
                                    @else
                                        <i class="fa fa-folder text-[#C9A84C] text-sm w-6 text-center"></i>
                                    @endif
                                    {{ $cat->name_en ?? $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div id="noCategory" class="hidden px-4 py-3 text-sm text-gray-400">{{ __('messages.no_categories_found') }}</div>
                    </div>

                    <div id="noResults" class="hidden px-4 py-3 text-sm text-gray-400 text-center">{{ __('messages.no_results_found') }}</div>
                </div>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-4">
               {{-- Cart --}}
                @php
                    $cartData  = session('cart', []);
                    $cartCount = array_sum(array_column($cartData, 'quantity'));
                @endphp
                <a href="{{ route('cart.index') }}#order_card" onclick="event.preventDefault(); window.navigateToCart ? window.navigateToCart() : window.location.href=this.href;" class="relative flex items-center gap-1.5 text-gray-600 hover:text-primary-600 transition-colors group">
                    <div class="relative">
                        <i class="fa-solid fa-bag-shopping text-[#28282A] text-xl group-hover:scale-110 transition-transform"></i>
                        <span id="cart-badge"
                              class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center animate-pulse-badge {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount ?: '' }}
                        </span>
                    </div>
                    <span class="hidden md:inline text-sm font-medium text-[#28282A] ml-1">{{ __('messages.cart') }}</span>
                </a>

                {{-- Mobile search toggle --}}
                <button class="sm:hidden text-gray-500 hover:text-primary-500" id="mobileSearchBtn">
                    <i class="fa fa-search text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Search --}}
        <div class="sm:hidden pb-3 hidden" id="mobileSearch">
            <div class="relative" id="mobileSearchWrapper">
                <form id="mobileSearchForm" action="{{ route('home') }}" method="GET" class="relative" autocomplete="off">
                    <input
                        type="text"
                        id="mobileSearchInput"
                        name="search"
                        value=""
                        placeholder="{{ __('messages.search_placeholder') }}"
                        class="w-full border border-gray-200 bg-gray-50 rounded-full py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                        oninput="handleMobileSearchInput(this.value)"
                        onfocus="handleMobileSearchInput(this.value)"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fa fa-search text-sm"></i>
                    </button>
                </form>

                {{-- Mobile Search Dropdown --}}
                <div id="mobileSearchDropdown"
                    class="absolute left-0 right-0 top-full mt-1 bg-white rounded-2xl shadow-lg border border-gray-100 z-50 hidden max-h-96 overflow-y-auto">

                    <div id="mobileProductSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">{{ __('messages.products') }}</p>
                        <ul id="mobileProductList"></ul>
                    </div>

                    <div id="mobileBrandSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">{{ __('messages.brands') }}</p>
                        <ul id="mobileBrandList"></ul>
                    </div>

                    <div id="mobileSkuSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-1 pb-1">{{ __('messages.sku') }}</p>
                        <ul id="mobileSkuList"></ul>
                    </div>

                    <div id="mobileCategorySection">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">{{ __('messages.categories') }}</p>
                        <ul id="mobileCategoryList">
                            @foreach($navCategories as $cat)
                            <li class="mobile-category-item"
                                data-name="{{ strtolower($cat->name_en ?? '') }}"
                                data-name-kh="{{ $cat->name_kh ?? '' }}">
                                <a href="{{ route('home') }}?category_id={{ $cat->id }}#product-grid"
                                    class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-sm text-gray-700">
                                    @if($cat->icon_url)
                                        <img src="{{ asset($cat->icon_url) }}" class="w-6 h-6 object-contain">
                                    @else
                                        <i class="fa fa-folder text-[#C9A84C] text-sm w-6 text-center"></i>
                                    @endif
                                    {{ $cat->name_en ?? $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div id="mobileNoCategory" class="hidden px-4 py-3 text-sm text-gray-400">{{ __('messages.no_categories_found') }}</div>
                    </div>

                    <div id="mobileNoResults" class="hidden px-4 py-3 text-sm text-gray-400 text-center">{{ __('messages.no_results_found') }}</div>
                </div>
            </div>
        </div>

    </div>
</nav>

<script>
    document.getElementById('mobileSearchBtn')?.addEventListener('click', () => {
        const mobileSearch = document.getElementById('mobileSearch');
        mobileSearch.classList.toggle('hidden');
        if (!mobileSearch.classList.contains('hidden')) {
            // Focus the input after showing
            setTimeout(() => document.getElementById('mobileSearchInput')?.focus(), 50);
        }
    });

    let _suggestTimer = null;
    let _mobileSuggestTimer = null;

    // Detect if text contains Khmer characters (U+1780–U+17FF)
    function isKhmer(text) {
        return /[\u1780-\u17FF]/.test(text);
    }

    // ─── Desktop search ───────────────────────────────────────────────────────

    function handleSearchInput(val) {
        const dropdown = document.getElementById('searchDropdown');
        const raw      = val.trim();
        const query    = raw.toLowerCase();
        const khmer    = isKhmer(raw);

        dropdown.classList.remove('hidden');

        filterCategories(query, '.category-item', 'noCategory');

        if (query.length < 1) {
            document.getElementById('productSection').classList.add('hidden');
            document.getElementById('brandSection').classList.add('hidden');
            document.getElementById('skuSection').classList.add('hidden');
            document.getElementById('noResults').classList.add('hidden');
            return;
        }

        clearTimeout(_suggestTimer);
        _suggestTimer = setTimeout(() => fetchSuggestions(raw, khmer ? 'km' : 'en', 'desktop'), 280);
    }

    // ─── Mobile search ────────────────────────────────────────────────────────

    function handleMobileSearchInput(val) {
        const dropdown = document.getElementById('mobileSearchDropdown');
        const raw      = val.trim();
        const query    = raw.toLowerCase();
        const khmer    = isKhmer(raw);

        dropdown.classList.remove('hidden');

        filterCategories(query, '.mobile-category-item', 'mobileNoCategory');

        if (query.length < 1) {
            document.getElementById('mobileProductSection').classList.add('hidden');
            document.getElementById('mobileBrandSection').classList.add('hidden');
            document.getElementById('mobileSkuSection').classList.add('hidden');
            document.getElementById('mobileNoResults').classList.add('hidden');
            return;
        }

        clearTimeout(_mobileSuggestTimer);
        _mobileSuggestTimer = setTimeout(() => fetchSuggestions(raw, khmer ? 'km' : 'en', 'mobile'), 280);
    }

    // ─── Shared helpers ───────────────────────────────────────────────────────

    function filterCategories(query, itemSelector, noCatId) {
        const catItems   = document.querySelectorAll(itemSelector);
        const noCategory = document.getElementById(noCatId);
        let catVisible = 0;
        catItems.forEach(item => {
            const nameEn = (item.dataset.name || '').toLowerCase();
            const nameKh = (item.dataset.nameKh || '').toLowerCase();
            const match  = query === '' || nameEn.includes(query) || nameKh.includes(query);
            item.style.display = match ? '' : 'none';
            if (match) catVisible++;
        });
        noCategory.classList.toggle('hidden', catVisible > 0);
    }

    function fetchSuggestions(q, lang, target) {
        fetch(`/search/suggestions?q=${encodeURIComponent(q)}&lang=${lang}`)
            .then(r => r.json())
            .then(data => {
                if (target === 'mobile') {
                    renderProducts(data.products || [], 'mobile');
                    renderBrands(data.brands || [], 'mobile');
                    renderSkus(data.skus || [], 'mobile');
                    const hasAny = (data.products.length + data.brands.length + data.skus.length) > 0 ||
                                   document.querySelectorAll('.mobile-category-item:not([style*="none"])').length > 0;
                    document.getElementById('mobileNoResults').classList.toggle('hidden', hasAny);
                } else {
                    renderProducts(data.products || [], 'desktop');
                    renderBrands(data.brands || [], 'desktop');
                    renderSkus(data.skus || [], 'desktop');
                    const hasAny = (data.products.length + data.brands.length + data.skus.length) > 0 ||
                                   document.querySelectorAll('.category-item:not([style*="none"])').length > 0;
                    document.getElementById('noResults').classList.toggle('hidden', hasAny);
                }
            })
            .catch(() => {});
    }

    function renderProducts(products, target) {
        const prefix  = target === 'mobile' ? 'mobile' : '';
        const section = document.getElementById(prefix ? 'mobileProductSection' : 'productSection');
        const list    = document.getElementById(prefix ? 'mobileProductList' : 'productList');
        const storeKey = prefix ? '_mobileSearchProductUrls' : '_searchProductUrls';

        if (!products.length) { section.classList.add('hidden'); list.innerHTML = ''; return; }

        window[storeKey] = {};
        products.forEach(p => { window[storeKey][p.id] = p.url; });

        const fnName = prefix ? 'goToProductMobile' : 'goToProduct';
        list.innerHTML = products.map(p => `
            <li>
                <button type="button"
                   onclick="${fnName}(${p.id})"
                   class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-left cursor-pointer">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                        ${p.image_url
                            ? `<img src="${escHtml(p.image_url)}" alt="${escHtml(p.name)}" class="w-full h-full object-contain p-1">`
                            : `<i class="fa fa-box text-[#C9A84C] text-sm"></i>`
                        }
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800 font-medium truncate">${escHtml(p.name)}</p>
                    </div>
                    <span class="text-sm font-bold text-[#C9A84C] flex-shrink-0">$${escHtml(p.price)}</span>
                </button>
            </li>`).join('');
        section.classList.remove('hidden');
    }

    function goToProduct(id) {
        const url = window._searchProductUrls && window._searchProductUrls[id];
        if (!url) return;
        document.getElementById('searchDropdown')?.classList.add('hidden');
        window.location.href = url + '#product-detail';
    }

    function goToProductMobile(id) {
        const url = window._mobileSearchProductUrls && window._mobileSearchProductUrls[id];
        if (!url) return;
        document.getElementById('mobileSearchDropdown')?.classList.add('hidden');
        window.location.href = url + '#product-detail';
    }

    function renderBrands(brands, target) {
        const section = document.getElementById(target === 'mobile' ? 'mobileBrandSection' : 'brandSection');
        const list    = document.getElementById(target === 'mobile' ? 'mobileBrandList' : 'brandList');
        const storeKey = target === 'mobile' ? '_mobileSearchBrandUrls' : '_searchBrandUrls';
        const fnName   = target === 'mobile' ? 'goToBrandMobile' : 'goToBrand';

        if (!brands.length) { section.classList.add('hidden'); list.innerHTML = ''; return; }

        window[storeKey] = {};
        brands.forEach(b => {
            window[storeKey][b.id] = '{{ route('home') }}?brand_id=' + b.id + '#product-grid';
        });

        list.innerHTML = brands.map(b => `
            <li>
                <button type="button"
                   onclick="${fnName}(${b.id})"
                   class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-left cursor-pointer">
                    <i class="fa fa-tag text-[#C9A84C] text-sm w-5 text-center"></i>
                    <span class="text-sm text-gray-700">${escHtml(b.name)}</span>
                </button>
            </li>`).join('');
        section.classList.remove('hidden');
    }

    function goToBrand(id) {
        const url = window._searchBrandUrls && window._searchBrandUrls[id];
        if (!url) return;
        document.getElementById('searchDropdown')?.classList.add('hidden');
        window.location.href = url;
    }

    function goToBrandMobile(id) {
        const url = window._mobileSearchBrandUrls && window._mobileSearchBrandUrls[id];
        if (!url) return;
        document.getElementById('mobileSearchDropdown')?.classList.add('hidden');
        window.location.href = url;
    }

    function renderSkus(skus, target) {
        const section = document.getElementById(target === 'mobile' ? 'mobileSkuSection' : 'skuSection');
        const list    = document.getElementById(target === 'mobile' ? 'mobileSkuList' : 'skuList');

        if (!skus.length) { section.classList.add('hidden'); list.innerHTML = ''; return; }

        list.innerHTML = skus.map(p => `
            <li>
                <a href="{{ route('home') }}?search=${encodeURIComponent(p.sku)}#product-grid"
                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-sm text-gray-700">
                    <i class="fa fa-barcode text-green-500 text-sm w-5 text-center"></i>
                    <span class="font-mono text-green-700">${escHtml(p.sku)}</span>
                    <span class="text-gray-400 truncate">${escHtml(p.name)}</span>
                </a>
            </li>`).join('');
        section.classList.remove('hidden');
    }

    function escHtml(str) {
        return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        const desktopWrapper = document.getElementById('searchWrapper');
        if (desktopWrapper && !desktopWrapper.contains(e.target)) {
            document.getElementById('searchDropdown')?.classList.add('hidden');
        }

        const mobileWrapper = document.getElementById('mobileSearchWrapper');
        const mobileBtn     = document.getElementById('mobileSearchBtn');
        if (mobileWrapper && !mobileWrapper.contains(e.target) && !mobileBtn?.contains(e.target)) {
            document.getElementById('mobileSearchDropdown')?.classList.add('hidden');
        }
    });
</script>
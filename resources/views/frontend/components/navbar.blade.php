
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
                        placeholder="Search products ..."
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
                    class="absolute left-0 right-0 top-full mt-1 bg-white rounded-2xl shadow-lg border border-gray-100 z-50 hidden max-h-80 overflow-y-auto">

                    {{-- Product name suggestions (AJAX) --}}
                    <div id="productSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">Products</p>
                        <ul id="productList"></ul>
                    </div>

                    {{-- Brand suggestions (AJAX) --}}
                    <div id="brandSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">Brands</p>
                        <ul id="brandList"></ul>
                    </div>

                    {{-- SKU suggestions (AJAX) --}}
                    <div id="skuSection" class="hidden">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-1 pb-1">SKU</p>
                        <ul id="skuList"></ul>
                    </div>

                    {{-- Categories (client-side filter) --}}
                    <div id="categorySection">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold px-4 pt-3 pb-1">Categories</p>
                        <ul id="categoryList">
                            @foreach($navCategories as $cat)
                            <li class="category-item" data-name="{{ strtolower($cat->name_en ?? $cat->name) }}">
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
                        <div id="noCategory" class="hidden px-4 py-3 text-sm text-gray-400">No categories found.</div>
                    </div>

                    <div id="noResults" class="hidden px-4 py-3 text-sm text-gray-400 text-center">No results found.</div>
                </div>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-4">
               {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1.5 text-gray-600 hover:text-primary-600 transition-colors group">
                    <div class="relative">
                        <i class="fa-solid fa-bag-shopping text-[#28282A] text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <span class="hidden md:inline text-sm font-medium text-[#28282A] ml-1">Cart</span>

                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
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

        {{-- Mobile Search --}}
        <div class="sm:hidden pb-3 hidden" id="mobileSearch">
            <form action="{{ route('home') }}" method="GET" class="relative">
                <input
                    type="text"
                    name="search"
                    placeholder="Search products..."
                    class="w-full border border-gray-200 bg-gray-50 rounded-full py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                >
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobileSearchBtn')?.addEventListener('click', () => {
        document.getElementById('mobileSearch').classList.toggle('hidden');
    });

    let _suggestTimer = null;

    function handleSearchInput(val) {
        const dropdown    = document.getElementById('searchDropdown');
        const query       = val.trim().toLowerCase();

        dropdown.classList.remove('hidden');

        // --- Categories (client-side) ---
        const catItems  = document.querySelectorAll('.category-item');
        const noCategory = document.getElementById('noCategory');
        let catVisible = 0;
        catItems.forEach(item => {
            const match = query === '' || (item.dataset.name || '').includes(query);
            item.style.display = match ? '' : 'none';
            if (match) catVisible++;
        });
        noCategory.classList.toggle('hidden', catVisible > 0);

        // Hide brand/sku sections while typing
        if (query.length < 1) {
            document.getElementById('productSection').classList.add('hidden');
            document.getElementById('brandSection').classList.add('hidden');
            document.getElementById('skuSection').classList.add('hidden');
            document.getElementById('noResults').classList.add('hidden');
            return;
        }

        // --- Brands + SKU (AJAX with debounce) ---
        clearTimeout(_suggestTimer);
        _suggestTimer = setTimeout(() => fetchSuggestions(query), 280);
    }

    function fetchSuggestions(q) {
        fetch(`/search/suggestions?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                renderProducts(data.products || []);
                renderBrands(data.brands || []);
                renderSkus(data.skus || []);

                const hasAny = (data.products.length + data.brands.length + data.skus.length) > 0 ||
                               document.querySelectorAll('.category-item:not([style*="none"])').length > 0;
                document.getElementById('noResults').classList.toggle('hidden', hasAny);
            })
            .catch(() => {});
    }

    function renderProducts(products) {
        const section = document.getElementById('productSection');
        const list    = document.getElementById('productList');
        if (!products.length) { section.classList.add('hidden'); list.innerHTML = ''; return; }

        list.innerHTML = products.map(p => `
            <li>
                <a href="{{ route('home') }}?search=${encodeURIComponent(p.name)}#product-grid"
                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-sm text-gray-700">
                    <i class="fa fa-box text-[#C9A84C] text-sm w-5 text-center"></i>
                    <span>${escHtml(p.name)}</span>
                </a>
            </li>`).join('');
        section.classList.remove('hidden');
    }

    function renderBrands(brands) {
        const section = document.getElementById('brandSection');
        const list    = document.getElementById('brandList');
        if (!brands.length) { section.classList.add('hidden'); list.innerHTML = ''; return; }

        list.innerHTML = brands.map(b => `
            <li>
                <a href="{{ route('home') }}?brand_id=${b.id}#product-grid"
                   data-filter-link="brand" data-brand-id="${b.id}"
                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#FFF8E7] transition-colors text-sm text-gray-700">
                    <i class="fa fa-tag text-blue-400 text-sm w-5 text-center"></i>
                    <span>${escHtml(b.name)}</span>
                </a>
            </li>`).join('');
        section.classList.remove('hidden');
    }

    function renderSkus(skus) {
        const section = document.getElementById('skuSection');
        const list    = document.getElementById('skuList');
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

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('searchWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('searchDropdown')?.classList.add('hidden');
        }
    });
</script>

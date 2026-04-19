<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>@yield('title', 'CPK Solution')</title> --}}

      <!-- Favicon from Settings -->
    @if($settings && $settings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $settings->favicon) }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $settings->favicon) }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <!-- Fallback favicon -->
        <link rel="icon" type="image/png" href="{{ asset('cpk_favicon.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('cpk_favicon.png') }}">
    @endif

    <title>@yield('title', 'Admin Dashboard') - CPK Solution</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
       
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#fff8e1',
                            100: '#ffecb3',
                            200: '#ffe082',
                            300: '#ffd54f',
                            350: '#D4AF56',
                            400: '#ffca28',
                            500: '#ffc107',
                            600: '#ffb300',
                            700: '#ffa000',
                            800: '#ff8f00',
                            900: '#ff6f00',
                        },
                        dark: {
                            DEFAULT: '#1a1a2e',
                            800: '#16213e',
                            700: '#0f3460',
                        },
                        accent: '#e94560',
                    },
                    fontFamily: {
                        sans: ['"Nunito"', 'sans-serif'],
                        display: ['"Poppins"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'pulse-badge': 'pulseBadge 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        pulseBadge: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.1)' },
                        },
                    },
                }
            }
        }
    </script>

    <style>
        /* Khmer Font Support */
        @import url('https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Nunito', 'Kantumruy Pro', sans-serif;
        }
        #product-detail {
            scroll-margin-top: 150px;
        }

         #order_card {
            scroll-margin-top: 200px;
        }
    </style>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- Top Header --}}
    @include('frontend.components.header')
    
    {{-- Main Navbar --}}
    @include('frontend.components.navbar')

    {{-- Show ONLY on homepage --}}
    @if (Route::currentRouteName() === 'home')
        @include('frontend.components.banner')
        
    @endif

    @php
        $filterBaseUrl = in_array(Route::currentRouteName(), ['pages.viewProduct', 'cart.index'])
            ? route('home')
            : url()->current();
    @endphp
    @include('frontend.components.categories', ['filterBaseUrl' => $filterBaseUrl])
    @include('frontend.components.brands', ['filterBaseUrl' => $filterBaseUrl])

    {{-- Page Content --}}
    <main class="animate-fade-in">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.components.footer')

    {{-- POP UP --}}
    @include('frontend.pages.popUp')

    {{-- @if (Route::currentRouteName() === 'home')
        @include('frontend.pages.popUp')
    @endif --}}

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')

    {{-- Cart toast --}}
    <div id="cart-toast"
        class="fixed bottom-6 right-6 z-50 px-5 py-3 rounded-xl text-white text-sm font-semibold shadow-lg opacity-0 pointer-events-none transition-opacity duration-300"
        style="background:#C9A84C;">
        Added to cart!
    </div>

    <script>
    (function () {

        // ── Shared AJAX filter function ─────────────────────────────────────
        function doFilterAjax(url, hash) {
            const container = document.getElementById('home-cards-container')
                           || document.getElementById('view-cards-container')
                           || document.getElementById('add-cards-container');
            if (!container) return false;

            container.style.opacity = '0.4';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                container.innerHTML     = data.html;
                container.style.opacity = '1';

                // Update category name & item count (home page)
                const nameEl  = document.getElementById('category-name');
                const countEl = document.getElementById('item-count');
                if (nameEl)  nameEl.textContent  = data.category_name || '';
                if (countEl) countEl.textContent = Number(data.total_items || 0).toLocaleString() + ' Items';

                // Update search badges (brand / SKU indicators)
                const params = new URLSearchParams(url.split('?')[1] || '');
                document.dispatchEvent(new CustomEvent('searchBadgesUpdate', { detail: {
                    searchQuery:     params.get('search') || '',
                    searchBrandName: data.search_brand_name || '',
                    searchSku:       data.search_sku || '',
                }}));

                // Active state — categories
                document.querySelectorAll('[data-filter-link="category"]').forEach(a => {
                    const active = String(a.dataset.catId) === String(data.category_id);
                    a.classList.toggle('bg-[#FFE3A1]', active);
                    a.classList.toggle('shadow-sm', active);
                });

                // Active state — brands
                document.querySelectorAll('[data-filter-link="brand"]').forEach(a => {
                    const active = String(a.dataset.brandId) === String(data.brand_id);
                    a.classList.toggle('bg-[#FFE3A1]', active);
                });

                history.pushState({}, '', url + (hash || ''));

                const grid = document.getElementById('product-grid');
                if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(() => { container.style.opacity = '1'; });

            return true;
        }

        // ── AJAX Category / Brand filter (click) ───────────────────────────
        document.addEventListener('click', function (e) {
            const link = e.target.closest('[data-filter-link]');
            if (!link) return;

            // Only do AJAX filtering when on the home page
            const homePath = new URL('{{ route("home") }}', window.location.origin).pathname.replace(/\/$/, '') || '/';
            const curPath  = window.location.pathname.replace(/\/$/, '') || '/';
            if (curPath !== homePath) return; // let normal navigation go to home

            // Build toggle URL dynamically from current params
            const params     = new URLSearchParams(window.location.search);
            const filterType = link.dataset.filterLink;

            if (filterType === 'brand') {
                const id = link.dataset.brandId;
                if (params.get('brand_id') === String(id)) {
                    params.delete('brand_id');   // second click → remove filter
                } else {
                    params.set('brand_id', id);  // first click → apply filter
                }
            } else if (filterType === 'category') {
                const id = link.dataset.catId;
                if (params.get('category_id') === String(id)) {
                    params.delete('category_id');
                } else {
                    params.set('category_id', id);
                }
            }

            params.delete('search');
            const basePath = window.location.pathname;
            const qs       = params.toString();
            const url      = basePath + (qs ? '?' + qs : '');

            if (!doFilterAjax(url, '#product-grid')) return;
            e.preventDefault();

            // Clear search input
            const searchInput = document.getElementById('searchInput');
            if (searchInput) searchInput.value = '';
            document.getElementById('searchDropdown')?.classList.add('hidden');
        });

        // ── AJAX Pagination ────────────────────────────────────────────────
        document.addEventListener('click', function (e) {
            const link = e.target.closest('[data-pagination-link]');
            if (!link) return;

            const pageParam = link.dataset.pageParam;
            const page      = link.dataset.page;

            const params = new URLSearchParams(window.location.search);
            params.set(pageParam, page);

            const url = window.location.pathname + '?' + params.toString();

            if (!doFilterAjax(url, '#product-grid')) return;
            e.preventDefault();
        });

        // ── AJAX Search (form submit) ───────────────────────────────────────
        document.addEventListener('submit', function (e) {
            const form = e.target.closest('#searchForm, #mobileSearchForm');
            if (!form) return;

            // Only intercept when the form's action targets the current page
            try {
                const formPath = new URL(form.action).pathname.replace(/\/$/, '') || '/';
                const curPath  = window.location.pathname.replace(/\/$/, '') || '/';
                if (formPath !== curPath) return;
            } catch (_) { return; }

            const input    = form.querySelector('input[name="search"]');
            const searchVal = input ? input.value.trim() : '';
            const url      = window.location.pathname + (searchVal ? '?search=' + encodeURIComponent(searchVal) : '');

            if (!doFilterAjax(url, '#product-grid')) return;

            e.preventDefault();
            if (input) input.value = '';
            document.getElementById('searchDropdown')?.classList.add('hidden');
        });

        // Reload on back/forward to restore correct filter state
        window.addEventListener('popstate', function () { location.reload(); });

        // ── SPA Page Navigation (product detail, cart, etc.) ────────────────
        function loadPage(url, hash, title) {
            const main = document.querySelector('main');
            if (!main) { window.location.href = url + (hash || ''); return; }

            main.style.opacity = '0.4';
            main.style.pointerEvents = 'none';

            fetch(url, { headers: { 'X-Partial': '1' } })
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(data => {
                    main.innerHTML = data.html;

                    // Re-execute inline scripts from injected content
                    main.querySelectorAll('script:not([src])').forEach(old => {
                        try {
                            const s = document.createElement('script');
                            s.textContent = old.textContent;
                            document.body.appendChild(s);
                            document.body.removeChild(s);
                        } catch (_) {}
                    });

                    main.style.opacity = '1';
                    main.style.pointerEvents = '';

                    history.pushState({ type: 'page' }, '', url + (hash || ''));
                    document.title = (data.title || title || '') + ' - CPK Solution';

                    // Scroll to top or anchor
                    const anchor = hash ? document.getElementById(hash.replace('#', '')) : null;
                    if (anchor) {
                        setTimeout(() => anchor.scrollIntoView({ behavior: 'smooth', block: 'start' }), 200);
                    } else {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                })
                .catch(() => {
                    window.location.assign(url + (hash || ''));
                })
                .finally(() => {
                    main.style.opacity = '1';
                    main.style.pointerEvents = '';
                });
        }

        document.addEventListener('click', function (e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href') || '';
            // Only intercept frontend product detail links
            if (!href.includes('/products/')) return;
            // Skip admin links
            if (href.includes('/admin/')) return;
            // Skip links that open in new tab
            if (link.target === '_blank') return;

            try {
                const fullUrl  = new URL(href, window.location.origin);
                const url  = fullUrl.origin + fullUrl.pathname + fullUrl.search;
                const hash = fullUrl.hash || '';

                e.preventDefault();
                loadPage(url, hash);
            } catch (_) {}
        });

        // ── SPA Navigate to Cart ────────────────────────────────────────────
        window.navigateToCart = function () {
            loadPage('{{ route("cart.index") }}', '#order_card', 'Cart');
        };

        // ── AJAX Add to Cart ────────────────────────────────────────────────
        window.addToCartAjax = function (url, btn) {
            btn.disabled = true;
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: 1 }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    window.navigateToCart();
                }
            })
            .finally(() => { btn.disabled = false; });
        };

        // ── Instant scroll to hash anchor ───────────────────────────────────
        const _hash = window.location.hash;
        if (_hash) {
            document.documentElement.style.scrollBehavior = 'auto';
            document.addEventListener('DOMContentLoaded', function () {
                const el = document.getElementById(_hash.slice(1));
                if (el) el.scrollIntoView();
                document.documentElement.style.scrollBehavior = '';
            });
        }
    })();
    </script>
</body>
</html>
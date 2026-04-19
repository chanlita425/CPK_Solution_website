@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')
@section('content')

    {{--- Link nav bar ---}}
    @include('frontend.components.product.navLink', ['product' => $product])

    {{--- View Product ---}}
    <section id="product-detail" class="px-20 sm:px-32 lg:px-28 py-4 sm:py-6">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-32">
            {{---- Main Product ----}}
            @include('frontend.components.product.mainProduct', ['product' => $product, 'thumbnails' => $thumbnails])

            {{---- Information Product ----}}
            @include('frontend.components.product.infoProduct', ['product' => $product])
        </div>
    </section>

    {{-- CARD PRODUCT - Only show if there are similar products --}}
    @if($totalItems > 0)
    <section id="product-grid" class="mt-8 lg:mt-16 sm:px-12 px-8 lg:px-4">
        <h2 class="text-center text-base sm:text-lg font-semibold mb-6 sm:mb-8" style="color:#C9A84C;">
            {{ __('messages.similar_items') }}
        </h2>

        <div id="similar-products-container">
            @include('frontend.components.cards.cardResponsive', [
                'productsXs' => $productsXs,
                'productsSm' => $productsSm,
                'productsLg' => $productsLg,
                'pageXs' => $pageXs,
                'pageSm' => $pageSm,
                'pageLg' => $pageLg,
                'totalPagesXs' => $totalPagesXs,
                'totalPagesSm' => $totalPagesSm,
                'totalPagesLg' => $totalPagesLg,
                'pgUrl' => $pgUrl,
                'filterBaseUrl' => $pgUrl,
                'promoPosition' => $promoPosition,
                'totalItems' => $totalItems,
                'categoryId' => $categoryId,
                'brandId' => $brandId,
                'isHome' => false,
                'promoImage' => $promoImage ?? null
            ])
        </div>
    </section>
    @endif

@endsection

@push('scripts')
<script>
    // Make category filters redirect to home page with category filter
    document.querySelectorAll('.category-filter-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-category-id');
            if (categoryId) {
                window.location.href = '{{ route("home") }}?category_id=' + categoryId + '#product-grid';
            }
        });
    });

    // Make brand filters redirect to home page with brand filter
    document.querySelectorAll('.brand-filter-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const brandId = this.getAttribute('data-brand-id');
            if (brandId) {
                window.location.href = '{{ route("home") }}?brand_id=' + brandId + '#product-grid';
            }
        });
    });

    // Pagination for similar items (works without refresh)
    let similarFilters = {
        page_xs: {{ $pageXs }},
        page_sm: {{ $pageSm }},
        page_lg: {{ $pageLg }}
    };

    let isLoading = false;

    function loadSimilarProducts() {
        if (isLoading) return;

        isLoading = true;

        const container = document.getElementById('similar-products-container');
        if (container) {
            container.style.opacity = '0.5';
        }

        let url = '{{ route("pages.viewProduct", $product->id) }}';
        let params = [];

        params.push('page_xs=' + similarFilters.page_xs);
        params.push('page_sm=' + similarFilters.page_sm);
        params.push('page_lg=' + similarFilters.page_lg);

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (container) {
                    container.innerHTML = data.similar_html;
                    container.style.opacity = '1';
                    attachPaginationHandlers();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (container) container.style.opacity = '1';
        })
        .finally(() => {
            isLoading = false;
        });
    }

    function handlePaginationClick(e) {
        e.preventDefault();
        e.stopPropagation();

        const page = parseInt(this.getAttribute('data-page'));
        if (isNaN(page)) return;

        const paginationDiv = this.closest('.pagination-xs, .pagination-sm, .pagination-lg');
        if (!paginationDiv) return;

        if (paginationDiv.classList.contains('pagination-xs')) {
            similarFilters.page_xs = page;
        } else if (paginationDiv.classList.contains('pagination-sm')) {
            similarFilters.page_sm = page;
        } else if (paginationDiv.classList.contains('pagination-lg')) {
            similarFilters.page_lg = page;
        }

        loadSimilarProducts();

        document.getElementById('product-grid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function attachPaginationHandlers() {
        document.querySelectorAll('.pagination-ajax-btn').forEach(btn => {
            btn.removeEventListener('click', handlePaginationClick);
            btn.addEventListener('click', handlePaginationClick);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        attachPaginationHandlers();
    });
</script>
@endpush

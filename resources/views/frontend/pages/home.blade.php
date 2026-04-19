@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')

@section('content')

    {{------------- Title Category ------------}}
    <div id="product-grid" style="scroll-margin-top: 80px;"></div>
    <div class="relative px-4 sm:px-8 lg:px-14 mt-24 mb-4 flex items-center justify-center">

        <!-- category name -->
        <h2 id="category-name" class="text-[20px] font-bold text-[#D7B259] text-center ">
            {{ $categoryName }}
        </h2>

        <!-- item  -->
        <span id="item-count" class="absolute right-4 sm:right-8 lg:right-14 px-5 py-1.5 rounded-full text-sm font-bold text-white shadow"
            style="background:#D7B259;">
            {{ number_format($totalItems) }} Items
        </span>

    </div>


    {{--- PROMO BANNER — xs / sm / md only (hidden lg+) ---}}
    {{-- @include('frontend.components.promotion.promoCard_md_xs') --}}

    {{-- Card Product --}}
    <div id="home-cards-container">
        @include('frontend.components.cards.cardResponsive')
    </div>

@endsection

@push('scripts')
<script>
    function addToCart(productId) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 }),
        }).then(r => r.json()).then(data => {
            console.log('Cart updated:', data);
        });
    }

    // Smooth-scroll to #product-grid after page loads if anchor is present
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash === '#product-grid') {
            const el = document.getElementById('product-grid');
            if (el) {
                setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
            }
        }
    });

    // Update search badges when AJAX response returns search_brand_name / search_sku
    document.addEventListener('searchBadgesUpdate', function (e) {
        const { searchBrandName, searchSku, searchQuery } = e.detail;
        const container = document.getElementById('search-badges');

        if (!searchQuery) {
            if (container) container.innerHTML = '';
            return;
        }

        let html = '';
        if (searchBrandName) {
            html += `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                <i class="fa fa-tag text-blue-400"></i> {{ __('messages.brand') }}: ${searchBrandName}
            </span>`;
        }
        if (searchSku) {
            html += `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                <i class="fa fa-barcode text-green-400"></i> {{ __('messages.sku') }}: ${searchSku}
            </span>`;
        }

        if (!container) {
            const div = document.createElement('div');
            div.id = 'search-badges';
            div.className = 'flex flex-wrap items-center justify-center gap-2 px-4 sm:px-8 lg:px-14 mb-4';
            div.innerHTML = html;
            document.getElementById('product-grid')?.insertAdjacentElement('afterend', div);
        } else {
            container.innerHTML = html;
        }
    });
</script>
@endpush
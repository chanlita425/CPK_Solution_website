@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')

@section('content')

    {{------------- Title Category ------------}}
    <div id="product-grid" style="scroll-margin-top: 80px;"></div>
    <div class="relative px-4 sm:px-8 lg:px-14 mt-24 mb-4 flex items-center justify-center">

        <!-- category name -->
        <h2 class="text-[20px] font-bold text-[#D7B259] text-center ">
            {{ $categoryName }}
        </h2>

        <!-- item  -->
        <span class="absolute right-4 sm:right-8 lg:right-14 px-5 py-1.5 rounded-full text-sm font-bold text-white shadow" 
            style="background:#D7B259;">
            {{ number_format($totalItems) }} Items
        </span>

    </div>


    {{--- PROMO BANNER — xs / sm / md only (hidden lg+) ---}}
    {{-- @include('frontend.components.promotion.promoCard_md_xs') --}}

    {{-- Card Product --}}
    @include('frontend.components.cards.cardResponsive')

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
</script>
@endpush
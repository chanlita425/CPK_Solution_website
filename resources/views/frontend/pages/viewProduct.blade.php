
@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')
@section('content')

    <!-- Add Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    {{--- Link nav bar ---}}
   @include('frontend.components.product.navLink', ['product' => $product])

   
    {{--- View Product ---}}
    <section class="px-20 sm:px-32 lg:px-28 py-4 sm:py-6">

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-32">
            {{---- Main Product ----}}
            @include('frontend.components.product.mainProduct', ['product' => $product])

            {{---- Infomation Product ----}}
            @include('frontend.components.product.infoProduct', ['product' => $product])
        </div>
        
    </section>


    {{-- CARD PRODUCT --}}
    <section id="product-grid" class="mt-8 lg:mt-16 sm:px-12 px-8 lg:px-4 ">
        <h2 class="text-center text-base sm:text-lg font-semibold mb-6 sm:mb-8" style="color:#C9A84C;">
            Similar Items
        </h2>   
        
        @include('frontend.components.cards.cardResponsive')

    </section>


@endsection

@push('scripts')
<script>
    let qty = 1;

    function changeQty(delta) {
        qty = Math.max(1, qty + delta);
        document.getElementById('qty-display').textContent = qty;
    }

    function selectThumb(index) {
        document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
            btn.classList.toggle('border-yellow-400', i === index);
            btn.classList.toggle('border-gray-200',   i !== index);
        });
    }

    function addToCart(productId) {
        console.log('Add to cart:', productId, 'qty:', qty);
    }
</script>
@endpush
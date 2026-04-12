
@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')
@section('content')

    <!-- Add Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    {{--- Link nav bar ---}}
   @include('frontend.components.product.navLink', ['product' => $product])

   
    {{--- View Product ---}}
    <section  id="product-detail" class="px-20 sm:px-32 lg:px-28 py-4 sm:py-6">

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
    function selectThumb(imageUrl, index) {
        const mainImage = document.getElementById('mainImage');
        const thumbs = document.querySelectorAll('.thumb-btn');

        if (mainImage) {
            mainImage.style.opacity = 0;
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = 1;
            }, 120);
        }

        thumbs.forEach((btn, i) => {
            if (i === index) {
                btn.classList.add('border-yellow-400');
                btn.classList.remove('border-gray-200');
            } else {
                btn.classList.remove('border-yellow-400');
                btn.classList.add('border-gray-200');
            }
        });
    }
</script>
@endpush
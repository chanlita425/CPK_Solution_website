
@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')
@section('content')

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
            {{ __('messages.similar_items') }}
        </h2>

        <div id="view-cards-container">
            @include('frontend.components.cards.cardResponsive')
        </div>

    </section>


@endsection
@push('scripts')
<script>
(function () {
    window.originalMainSrc    = document.getElementById('mainImage')?.src ?? null;
    window.activeThumbIndex   = null;
    window.selectedImagePath  = null;

    window.selectThumb = function (imageUrl, index) {
        const mainImage = document.getElementById('mainImage');
        const thumbs    = document.querySelectorAll('.thumb-btn');
        if (!mainImage) return;

        const isReverting = window.activeThumbIndex === index;
        const targetSrc   = isReverting ? window.originalMainSrc : imageUrl;

        mainImage.style.opacity = 0;
        setTimeout(() => {
            mainImage.src           = targetSrc;
            mainImage.style.opacity = 1;
        }, 120);

        window.activeThumbIndex  = isReverting ? null : index;
        window.selectedImagePath = isReverting ? null : (thumbs[index]?.dataset.image ?? null);

        thumbs.forEach((btn, i) => {
            btn.classList.toggle('border-yellow-400', i === window.activeThumbIndex);
            btn.classList.toggle('border-gray-200',   i !== window.activeThumbIndex);
        });
    };
})();
</script>
@endpush
{{-- resources/views/frontend/components/product-grid.blade.php --}}
@props([
    'products' => [],
    'isHome' => false,
    'promoImage' => null,
    'categoryId' => null,
    'brandId' => null,
])

{{-- XS Grid --}}
<div class="block sm:hidden px-4 pb-2">
    <div class="flex flex-col gap-3">
        @foreach($products as $product)
            @include('frontend.components.cards.card', ['product' => $product])
        @endforeach
    </div>
</div>

{{-- SM/MD Grid --}}
<div class="hidden sm:block lg:hidden px-4 sm:px-8 pb-2">
    <div class="grid grid-cols-2 gap-4">
        @foreach($products as $product)
            @include('frontend.components.cards.card', ['product' => $product])
        @endforeach
    </div>
</div>

{{-- LG Grid --}}
<div class="hidden lg:block px-14 pb-2">
    <div class="grid grid-cols-4 gap-4">
        @foreach($products as $index => $product)
            @if(!empty($isHome) && $isHome && $index === 4 && empty($categoryId) && empty($brandId) && $promoImage)
                @include('frontend.components.promotion.promoCard')
            @endif

            @include('frontend.components.cards.card', ['product' => $product])
        @endforeach
    </div>
</div>

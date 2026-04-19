{{-- XS Grid --}}
<div class="block sm:hidden px-4 pb-2">
    <div class="flex flex-col gap-3">
        @foreach($productsXs as $product)
            @include('frontend.components.cards.card', ['product' => $product])
        @endforeach
    </div>

    {{-- XS Pagination --}}
    @if($totalPagesXs > 1)
        <div class="flex items-center justify-center gap-1 mt-5 pb-4 pagination-xs">
            @include('frontend.components.pagination', [
                'page' => $pageXs,
                'total' => $totalPagesXs,
                'size' => 'xs',
                'ajax' => true,
                'pageParam' => 'page_xs'
            ])
        </div>
    @endif
</div>

{{-- SM/MD Grid --}}
<div class="hidden sm:block lg:hidden px-4 sm:px-8 pb-2">
    <div class="grid grid-cols-2 gap-4">
        @foreach($productsSm as $product)
            @include('frontend.components.cards.card', ['product' => $product])
        @endforeach
    </div>

    {{-- SM/MD Pagination --}}
    @if($totalPagesSm > 1)
        <div class="flex items-center justify-center gap-1 mt-5 pb-4 pagination-sm">
            @include('frontend.components.pagination', [
                'page' => $pageSm,
                'total' => $totalPagesSm,
                'size' => 'sm',
                'ajax' => true,
                'pageParam' => 'page_sm'
            ])
        </div>
    @endif
</div>

{{-- LG Grid --}}
<div class="hidden lg:block px-14 pb-2">
    <div class="grid grid-cols-4 gap-4">
        @foreach($productsLg as $index => $product)
            {{-- ONLY show promo card on homepage with no filters --}}
            @if(!empty($isHome) && $isHome && $index === 4 && empty($categoryId) && empty($brandId) && isset($promoImage) && $promoImage)
                @include('frontend.components.promotion.promoCard')
            @endif

            @include('frontend.components.cards.card', ['product' => $product])
        @endforeach
    </div>

    {{-- LG Pagination --}}
    @if($totalPagesLg > 1)
        <div class="flex items-center justify-center gap-1 mt-6 pb-10 pagination-lg">
            @include('frontend.components.pagination', [
                'page' => $pageLg,
                'total' => $totalPagesLg,
                'size' => 'lg',
                'ajax' => true,
                'pageParam' => 'page_lg'
            ])
        </div>
    @endif
</div>

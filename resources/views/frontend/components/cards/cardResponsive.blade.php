
    {{-- XS Grid --}}
    <div class="block sm:hidden px-4 pb-2">
        <div class="flex flex-col gap-3">
            @foreach($productsXs as $product)
                @include('frontend.components.cards.card', ['product' => $product])
            @endforeach
        </div>

        {{-- XS Pagination --}}
        <div class="flex items-center justify-center gap-1 mt-5 pb-4">
            @include('frontend.components.pagination', [
                'page' => $pageXs,
                'total' => $totalPagesXs,
                'size' => 'xs',
                'pgUrl' => fn($p) => url()->current() . '?page_xs=' . $p . '#product-grid',
                'pageParam' => 'page_xs'
            ])
        </div>
    </div>

    {{-- SM/MD Grid --}}
    <div class="hidden sm:block lg:hidden px-4 sm:px-8 pb-2">
        <div class="grid grid-cols-2 gap-4">
            @foreach($productsSm as $product)
                @include('frontend.components.cards.card', ['product' => $product])
            @endforeach
        </div>

        {{-- SM/MD Pagination --}}
        <div class="flex items-center justify-center gap-1 mt-5 pb-4">
            @include('frontend.components.pagination', [
                'page' => $pageSm,
                'total' => $totalPagesSm,
                'size' => 'sm',
                'pgUrl' => fn($p) => url()->current() . '?page_sm=' . $p . '#product-grid',
                'pageParam' => 'page_sm'
            ])
        </div>
    </div>

    {{-- Lg Grid --}}
    <div class="hidden lg:block px-14 pb-2">
        <div class="grid grid-cols-4 gap-4">
            @foreach($productsLg as $index => $product)
                @if(!empty($isHome) && $isHome && $index === 4 && empty($categoryId) && empty($brandId))
                    @include('frontend.components.promotion.promoCard')
                @endif

                @include('frontend.components.cards.card', ['product' => $product])
            @endforeach
        </div>

        {{-- LG Pagination --}}
        <div class="flex items-center justify-center gap-1 mt-6 pb-10">
            @include('frontend.components.pagination', [
                'page' => $pageLg,
                'total' => $totalPagesLg,
                'size' => 'lg',
                'pgUrl' => fn($p) => url()->current() . '?page_lg=' . $p . '#product-grid',
                'pageParam' => 'page_lg'
            ])
        </div>
    </div>
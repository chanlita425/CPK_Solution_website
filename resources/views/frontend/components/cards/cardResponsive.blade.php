

    {{-- sm - xs --}}
    <div class="block sm:hidden px-4 pb-2">
        <div class="flex flex-col gap-3">
            @foreach($productsXs as $product)
                @include('frontend.components.cards.card')
            @endforeach
        </div>

        {{-- XS Pagination --}}
        <div class="flex items-center justify-center gap-1 mt-5 pb-4">
            @include('frontend.components.pagination', [
                'page' => $pageXs,
                'total' => $totalPagesXs,
                'size' => 'xs',
                'pgUrl' => $pgUrl
            ])
        </div>
    </div>


    {{--- SM/MD GRID (540–899px) — 2 col · 5 rows = 10 cards ---}}
    <div class="hidden sm:block lg:hidden px-4 sm:px-8 pb-2">
        <div class="grid grid-cols-2 gap-4">
            @foreach($productsSm as $product)
                {{-- card prodect --}}
                @include('frontend.components.cards.card')
            @endforeach
        </div>

        {{-- SM/MD Pagination --}}
        <div class="flex items-center justify-center gap-1 mt-5 pb-4">  
        @include('frontend.components.pagination', [
                'page' => $pageSm,   
                'total' => $totalPagesSm,
                'size' => 'sm',
                'pgUrl' => $pgUrl
            ])
        </div>
    </div>


    <div class="hidden lg:block px-14 pb-2">
        <div class="grid grid-cols-4 gap-4">
            @foreach($productsLg as $index => $product) 
                    {{--- product card ---}}
                    @include('frontend.components.cards.card')
            @endforeach
        </div>

        {{-- LG+ Pagination --}}
        <div class="flex items-center justify-center gap-1 mt-6 pb-10">
            @include('frontend.components.pagination', [
                'page' => $pageLg,
                'total' => $totalPagesLg,
                'size' => 'lg',
                'pgUrl' => $pgUrl
            ])
        </div>
    </div>
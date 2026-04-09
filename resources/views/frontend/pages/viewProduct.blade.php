@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')

@section('content')

<!-- Add Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
@php
    $product = $product ?? [
        'id'          => 1,
        'name'        => 'AKIRA AIR-FRYER 3.5L 1400W - AFR-261A',
        'brand'       => 'AKIRA',
        'sku'         => 'AFR-261A',
        'price'       => 39.90,
        'image'       => null,
        'gallery'     => [null, null, null, null],
        'specs'       => [
            'Capacity: 3.5L',
            'Detachable oil pot',
            'Non-Stick cooking surface',
            'Overheat protection',
            'Easy-to-read and adjustable display',
            'Easy to clean and time saving',
            'Power:220-240V~, 50-60Hz, 1400W',
            'Dimension(HxWxD)(mm):330×260×240mm',
        ],
        'slug'        => 'akira-air-fryer-afr-261a',
        'breadcrumbs' => [
            ['label' => 'Home',              'url' => '/'],
            ['label' => 'Products',          'url' => '/products'],
            ['label' => 'Kitchen Appliance', 'url' => '/category/kitchen-appliance'],
            ['label' => 'Air Fryer',         'url' => '/category/air-fryer'],
        ],
    ];

     $allProducts = collect([
        ['id'=>1,  'name'=>'Smart Lock Pro X1',     'model'=>'Wi-Fi + Fingerprint · SLP-X1', 'price'=>89.90,   'image'=>null,'slug'=>'smart-lock-pro-x1'],
     ]);

    $categoryName = $categoryName ?? 'Smart Lock';
    $totalItems   = $allProducts->count();
    $currentPage  = max(1, (int) request('page', 1));

    $perXs = 4;   // xs:  1 col × 4 rows
    $perSm = 4;  // sm/md: 2 col × 2 rows
    $perLg = 8;  // lg+: 4 col × ~4 rows (+ 1 promo slot = effectively 14 product cards per page)

    $totalPagesXs = (int) ceil($totalItems / $perXs);   // 6
    $totalPagesSm = (int) ceil($totalItems / $perSm);   // 3
    $totalPagesLg = (int) ceil($totalItems / $perLg);   // 2

    $pageXs = max(1, min($currentPage, $totalPagesXs));
    $pageSm = max(1, min($currentPage, $totalPagesSm));
    $pageLg = max(1, min($currentPage, $totalPagesLg));

    $productsXs = $allProducts->slice(($pageXs - 1) * $perXs, $perXs)->values();
    $productsSm = $allProducts->slice(($pageSm - 1) * $perSm, $perSm)->values();
    $productsLg = $allProducts->slice(($pageLg - 1) * $perLg, $perLg)->values();

    $promoPosition = 4;

    $lgCount     = $productsLg->count();
    $lgTotalSlots = $lgCount + 1; // +1 for promo card
    $lgRemainder  = $lgTotalSlots % 4;
    $lgFillCount  = $lgRemainder === 0 ? 0 : (4 - $lgRemainder);

    $pgUrl = fn(int $p) => request()->url() . '?page=' . $p . '#product-grid';

@endphp

    {{--- Link nav bar ---}}
    @include('frontend.components.product.navLink')

    {{--- View Product ---}}
    <section class="px-20 sm:px-32 lg:px-28 py-4 sm:py-6">

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-32">
            {{---- Main Product ----}}
            @include('frontend.components.product.mainProduct')

            {{---- Infomation Product ----}}
            @include('frontend.components.product.infoProduct')
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
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
        ['id'=>1,  'name'=>'Smart Lock Pro X1',     'model'=>'Wi-Fi + Fingerprint · SLP-X1', 'price'=>89.90,  'image'=>null,'slug'=>'smart-lock-pro-x1'],
        ['id'=>2,  'name'=>'Yale Assure Lock 2',    'model'=>'Bluetooth · YAL-2022',          'price'=>124.99, 'image'=>null,'slug'=>'yale-assure-lock-2'],
        ['id'=>3,  'name'=>'Schlage Encode Plus',   'model'=>'Apple HomeKey · SEP-100',       'price'=>149.00, 'image'=>null,'slug'=>'schlage-encode-plus'],
        ['id'=>4,  'name'=>'August Wi-Fi Lock',     'model'=>'4th Gen · AUG-WF4',             'price'=>99.95,  'image'=>null,'slug'=>'august-wifi-lock'],
        ['id'=>5,  'name'=>'Ultraloq U-Bolt Pro',   'model'=>'6-in-1 · UL3-PRO',             'price'=>109.99, 'image'=>null,'slug'=>'ultraloq-u-bolt-pro'],
        ['id'=>6,  'name'=>'Kwikset Halo Touch',    'model'=>'Fingerprint · KWI-HT1',         'price'=>118.00, 'image'=>null,'slug'=>'kwikset-halo-touch'],
        ['id'=>7,  'name'=>'Lockly Secure Pro',     'model'=>'PIN Genie · LKL-SP2',           'price'=>199.00, 'image'=>null,'slug'=>'lockly-secure-pro'],
        ['id'=>8,  'name'=>'Level Lock+',           'model'=>'HomeKey · LVL-LKP',             'price'=>179.00, 'image'=>null,'slug'=>'level-lock-plus'],
        ['id'=>9,  'name'=>'Eufy Security Lock',    'model'=>'Touch & Wi-Fi · EUF-T10',       'price'=>79.99,  'image'=>null,'slug'=>'eufy-security-lock'],
        ['id'=>10, 'name'=>'Igloohome Deadbolt 2S', 'model'=>'Bluetooth · IGL-DB2S',          'price'=>139.00, 'image'=>null,'slug'=>'igloohome-deadbolt-2s'],
        ['id'=>11, 'name'=>'Wyze Lock Bolt',        'model'=>'Fingerprint · WYZ-LB1',         'price'=>49.99,  'image'=>null,'slug'=>'wyze-lock-bolt'],
        ['id'=>12, 'name'=>'Nuki Smart Lock Pro',   'model'=>'Matter · NUK-SL40',             'price'=>229.00, 'image'=>null,'slug'=>'nuki-smart-lock-pro'],
        ['id'=>13, 'name'=>'Friday Lock Lite',      'model'=>'Bluetooth · FRI-LT1',           'price'=>69.00,  'image'=>null,'slug'=>'friday-lock-lite'],
        ['id'=>14, 'name'=>'Teeho Fingerprint',     'model'=>'Keyless · TEE-F1',              'price'=>55.90,  'image'=>null,'slug'=>'teeho-fingerprint'],
        ['id'=>15, 'name'=>'Sifely Keyless Entry',  'model'=>'Keypad · SIF-K22',              'price'=>44.99,  'image'=>null,'slug'=>'sifely-keyless-entry'],
        ['id'=>16, 'name'=>'Master Lock Connect',   'model'=>'Bluetooth · MST-CON1',          'price'=>59.99,  'image'=>null,'slug'=>'master-lock-connect'],
        ['id'=>17, 'name'=>'Bosma X1 Smart Lock',   'model'=>'Wi-Fi · BOS-X1',               'price'=>74.99,  'image'=>null,'slug'=>'bosma-x1-smart-lock'],
        ['id'=>18, 'name'=>'Samsung SHP-DP728',     'model'=>'Push-Pull · SHD-728',           'price'=>299.00, 'image'=>null,'slug'=>'samsung-shp-dp728'],
        ['id'=>19, 'name'=>'Igloohome Rim Lock',    'model'=>'Bluetooth · IGL-RM1',           'price'=>119.00, 'image'=>null,'slug'=>'igloohome-rim-lock'],
        ['id'=>20, 'name'=>'Hornbill Smart Lock',   'model'=>'Keypad · HBL-KP3',             'price'=>62.99,  'image'=>null,'slug'=>'hornbill-smart-lock'],
        ['id'=>21, 'name'=>'Turbolock TL-111',      'model'=>'Keypad · TBL-111',             'price'=>39.99,  'image'=>null,'slug'=>'turbolock-tl-111'],
        ['id'=>22, 'name'=>'Danalock V3',           'model'=>'Bluetooth · DAN-V3',            'price'=>159.00, 'image'=>null,'slug'=>'danalock-v3'],
        ['id'=>23, 'name'=>'Brinks Smart Deadbolt', 'model'=>'Smart Deadbolt · BRK-SD1',      'price'=>84.99,  'image'=>null,'slug'=>'brinks-smart-deadbolt'],
        ['id'=>24, 'name'=>'Anviz W1 Pro',          'model'=>'Fingerprint · ANV-W1P',         'price'=>95.00,  'image'=>null,'slug'=>'anviz-w1-pro'],
        ['id'=>25, 'name'=>'Aqara Smart Lock U100', 'model'=>'HomeKey · AQR-U100',            'price'=>189.99, 'image'=>null,'slug'=>'aqara-smart-lock-u100'],
        ['id'=>26, 'name'=>'Welock PCB41',          'model'=>'Cylinder · WLK-PCB41',          'price'=>129.00, 'image'=>null,'slug'=>'welock-pcb41'],
        ['id'=>27, 'name'=>'Philips EasyKey 9300',  'model'=>'Wi-Fi · PHI-9300',             'price'=>249.00, 'image'=>null,'slug'=>'philips-easykey-9300'],
        ['id'=>28, 'name'=>'Igloohome Keybox 3',    'model'=>'Bluetooth · IGL-KB3',           'price'=>159.00, 'image'=>null,'slug'=>'igloohome-keybox-3'],
        ['id'=>29, 'name'=>'Ttlock G2 Pro',         'model'=>'Fingerprint · TTL-G2P',         'price'=>68.99,  'image'=>null,'slug'=>'ttlock-g2-pro'],
        ['id'=>30, 'name'=>'Ultraloq U-Bolt',       'model'=>'5-in-1 · UL3-STD',             'price'=>79.99,  'image'=>null,'slug'=>'ultraloq-u-bolt'],
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
    <section class="px-[5rem] sm:px-[8rem] lg:px-[7rem] py-4 sm:py-6">

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-[8rem]">
            {{---- Main Product ----}}
            @include('frontend.components.product.mainProduct')

            {{---- Infomation Product ----}}
            @include('frontend.components.product.infoProduct')
        </div>
        
    </section>


    {{-- CARD PRODUCT --}}
    <section id="product-grid" class="mt-8 lg:mt-16 sm:px-12 px-8 lg:px-4 sm:px-4">

        <div class="block sm:hidden px-4 pb-2">
            <div class="flex flex-col gap-3">
                @foreach($productsXs as $product)
                    @include('frontend.components.cards.card_xs')
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
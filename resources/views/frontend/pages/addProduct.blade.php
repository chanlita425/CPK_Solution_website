@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')

@section('content')

@php
$cartItems = $cartItems ?? [
    [
        'id'    => 1,
        'name'  => 'AKIRA AIR-FRYER 3.5L 1400W - AFR-261A',
        'price' => 39.90,
        'qty'   => 1,
        'image' => null,
        'slug'  => 'akira-air-fryer-afr-261a',
    ],
    [
        'id'    => 2,
        'name'  => 'AKIRA AIR-FRYER 3.5L 1400W - AFR-261A',
        'price' => 39.90,
        'qty'   => 1,
        'image' => null,
        'slug'  => 'akira-air-fryer-afr-261a',
    ],
];

$subtotal = $subtotal ?? 208.00;
$shipping = $shipping ?? 2.00;
$tax      = $tax      ?? 0.00;
$total    = $subtotal + $shipping + $tax;

$similarItems = $similarItems ?? collect(array_fill(0, 4, [
    'id'    => 1,
    'name'  => 'AKIRA AIR-FRYER',
    'model' => '3.5L 1400W - AFR-261A',
    'price' => 39.90,
    'image' => null,
    'slug'  => 'akira-air-fryer-afr-261a',
]));

$currentPage = $currentPage ?? 1;
$totalPages  = $totalPages  ?? 10;
$nextPage    = $currentPage + 1;
@endphp

{{-- ══════════════════════════════════════
     CART + SUMMARY (two-column on lg)
══════════════════════════════════════ --}}
<section class="px-3 sm:px-6 lg:px-14 py-4 sm:py-6">
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6 items-start">

        {{-- ── LEFT: Cart items ── --}}
        <div class="w-full lg:w-[55%] flex flex-col gap-3 sm:gap-4">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-2xl sm:rounded-[20px] border border-gray-100 shadow-sm
                        flex items-center gap-3 sm:gap-5 p-3 sm:p-4">

                {{-- Product image --}}
                <a href="{{ url('/product/' . $item['slug']) }}"
                   class="shrink-0 w-20 h-20 sm:w-28 sm:h-28 lg:w-32 lg:h-32 flex items-center justify-center">
                    @if($item['image'])
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                             class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full bg-gray-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-box text-gray-300 text-2xl sm:text-3xl"></i>
                        </div>
                    @endif
                </a>

                {{-- Info + qty --}}
                <div class="flex-1 min-w-0 flex flex-col gap-1 sm:gap-2">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 truncate leading-snug">
                        {{ $item['name'] }}
                    </p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">
                        ${{ number_format($item['price'], 2) }}
                    </p>

                    {{-- Qty stepper --}}
                    <div class="flex items-center gap-0 mt-1 border border-gray-200 rounded-full w-fit overflow-hidden">
                        <button onclick="changeCartQty({{ $item['id'] }}, -1)"
                                class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-gray-500
                                       hover:bg-gray-100 transition-colors text-sm font-bold">
                            −
                        </button>
                        <span id="qty-{{ $item['id'] }}"
                              class="w-8 sm:w-10 text-center text-sm sm:text-base font-semibold text-gray-700">
                            {{ $item['qty'] }}
                        </span>
                        <button onclick="changeCartQty({{ $item['id'] }}, 1)"
                                class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-gray-500
                                       hover:bg-gray-100 transition-colors text-sm font-bold">
                            +
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── RIGHT: Order summary ── --}}
        <div class="w-full lg:w-[45%] bg-white rounded-2xl sm:rounded-[20px] border border-gray-100 shadow-sm p-4 sm:p-6 flex flex-col gap-4 sm:gap-5">

            {{-- Coupon --}}
            <div class="flex items-center gap-2">
                <input type="text"
                       placeholder="Coupon Code"
                       class="flex-1 bg-[#FAF6EE] rounded-full px-4 py-2.5 text-sm text-gray-600 placeholder-gray-400
                              outline-none focus:ring-2 focus:ring-yellow-300 transition-all">
                <button class="px-5 py-2.5 rounded-full text-sm font-semibold text-gray-700 hover:brightness-95 transition-all"
                        style="background:#F5E6C8;">
                    Apply
                </button>
            </div>

            {{-- Divider --}}
            <hr class="border-gray-100">

            {{-- Line items --}}
            <div class="flex flex-col gap-2 sm:gap-3 text-sm sm:text-base text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-medium text-gray-800">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span class="font-medium text-gray-800">${{ number_format($shipping, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax</span>
                    <span class="font-medium text-gray-800">${{ number_format($tax, 2) }}</span>
                </div>
            </div>

            {{-- Total --}}
            <div class="flex justify-between items-center pt-1">
                <span class="text-xl sm:text-2xl font-black text-gray-900">Total</span>
                <span class="text-2xl sm:text-3xl font-black" style="color:#C9A84C;">
                    ${{ number_format($total, 2) }}
                </span>
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-wrap gap-2 pt-1">
                {{-- Clear Cart --}}
                <button onclick="clearCart()"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-full border border-gray-200
                               text-xs sm:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                    <i class="fas fa-shopping-cart text-xs"></i>
                    Clear Cart
                </button>

                {{-- Shopping --}}
                <a href="{{ url('/products') }}"
                   class="flex items-center gap-2 px-4 py-2.5 rounded-full border border-gray-200
                          text-xs sm:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                    <i class="fas fa-bag-shopping text-xs"></i>
                    Shopping
                </a>

                {{-- Check Out --}}
                <a href="{{ url('/checkout') }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold text-white
                          hover:brightness-95 transition-all shadow-md ml-auto"
                   style="background:#C9A84C;">
                    <i class="fas fa-arrow-right-to-bracket text-xs"></i>
                    Check Out Now
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     SIMILAR ITEMS
══════════════════════════════════════ --}}
<section class="px-3 sm:px-6 lg:px-14 py-6 sm:py-10">

    <h2 class="text-center text-base sm:text-lg font-semibold mb-6 sm:mb-8" style="color:#C9A84C;">
        Similar Items
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
        @foreach($similarItems as $index => $item)

            {{-- Last card → next page --}}
            @if($loop->last && $currentPage < $totalPages)
                <a href="?page={{ $nextPage }}"
                   class="rounded-[20px] sm:rounded-[24px] bg-[#FAF6EE] flex flex-col items-center justify-center
                          p-4 gap-2 sm:gap-3 hover:shadow-md transition-all group
                          border-2 border-dashed border-yellow-300 hover:border-yellow-500 min-h-[200px] sm:min-h-[240px]">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center
                                transition-transform group-hover:scale-110" style="background:#C9A84C;">
                        <i class="fas fa-chevron-right text-white text-base sm:text-xl"></i>
                    </div>
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-bold text-gray-700 group-hover:text-yellow-600 transition-colors">Next Page</p>
                        <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">Page {{ $nextPage }} of {{ $totalPages }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-semibold text-white" style="background:#C9A84C;">
                        View More →
                    </span>
                </a>

            @else
                <div class="rounded-[20px] sm:rounded-[24px] bg-[#FAF6EE] flex flex-col items-center p-3 sm:p-4 gap-2 hover:shadow-md transition-shadow">

                    <a href="{{ url('/product/' . $item['slug']) }}"
                       class="w-full flex items-center justify-center h-28 sm:h-36 lg:h-40">
                        @if($item['image'])
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                 class="max-h-full object-contain">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-box text-gray-400 text-2xl sm:text-3xl"></i>
                            </div>
                        @endif
                    </a>

                    <a href="{{ url('/product/' . $item['slug']) }}"
                       class="text-center font-semibold text-gray-700 hover:text-yellow-600 transition-colors
                              leading-snug uppercase tracking-wide text-[10px] sm:text-xs">
                        {{ $item['name'] }}<br>
                        <span class="font-normal text-gray-500">{{ $item['model'] }}</span>
                    </a>

                    <span class="px-3 sm:px-4 py-1 rounded-full bg-gray-800 text-white font-bold text-[10px] sm:text-xs">
                        ${{ number_format($item['price'], 2) }}
                    </span>

                    <button onclick="addToCart({{ $item['id'] }})"
                            class="w-full py-2 sm:py-2.5 rounded-full font-semibold text-white
                                   hover:brightness-95 transition-all shadow-sm text-xs sm:text-sm"
                            style="background:#C9A84C;">
                        Add to Cart
                    </button>
                </div>
            @endif

        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════
     PAGINATION
══════════════════════════════════════ --}}
<div class="flex items-center justify-center gap-1 pb-10 flex-wrap px-4">
    @if($currentPage > 1)
        <a href="?page={{ $currentPage - 1 }}"
           class="w-2.5 h-2.5 rounded-full bg-yellow-500 mx-1 hover:bg-yellow-600 transition-colors"></a>
    @else
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-200 mx-1"></span>
    @endif

    @for($p = 1; $p <= $totalPages; $p++)
        @if($p == $currentPage)
            <a href="?page={{ $p }}"
               class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center
                      text-xs sm:text-sm font-bold text-white shadow"
               style="background:#C9A84C;">{{ $p }}</a>
        @else
            <a href="?page={{ $p }}"
               class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center
                      text-xs sm:text-sm font-medium text-gray-500 hover:bg-yellow-100 transition-colors">
               {{ $p }}
            </a>
        @endif
    @endfor

    @if($currentPage < $totalPages)
        <a href="?page={{ $nextPage }}"
           class="w-2.5 h-2.5 rounded-full bg-yellow-500 mx-1 hover:bg-yellow-600 transition-colors"></a>
    @else
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-200 mx-1"></span>
    @endif
</div>

@endsection

@push('scripts')
<script>
    const cartQtys = {
        @foreach($cartItems as $item)
            {{ $item['id'] }}: {{ $item['qty'] }},
        @endforeach
    };

    function changeCartQty(id, delta) {
        cartQtys[id] = Math.max(1, (cartQtys[id] || 1) + delta);
        const el = document.getElementById('qty-' + id);
        if (el) el.textContent = cartQtys[id];
        // TODO: sync with server via fetch/Livewire
    }

    function clearCart() {
        // TODO: wire to your cart logic
        console.log('Clear cart');
    }

    function addToCart(productId) {
        console.log('Add to cart:', productId);
    }
</script>
@endpush
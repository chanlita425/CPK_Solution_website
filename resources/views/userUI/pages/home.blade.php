@extends('userUI.layouts.app')

@section('content')


@section('title', 'CPK Solution – Home')

@section('content')
@php
$categoryName = $categoryName ?? 'Smart Lock';
$totalItems   = $totalItems   ?? 700;
$currentPage  = $currentPage  ?? 1;
$totalPages   = $totalPages   ?? 10;

// Promotion board inserted at position index 4 (second row, first column)
$promoPosition = 4;

$products = $products ?? collect(array_fill(0, 15, [
    'id'    => 1,
    'name'  => 'AKIRA AIR-FRYER',
    'model' => '3.5L 1400W - AFR-261A',
    'price' => 39.90,
    'image' => null,   // replace with real image path
    'slug'  => 'akira-air-fryer-afr-261a',
]));

$nextPage = $currentPage + 1;
@endphp

{{-- ── Header ── --}}
<div class="px-4 sm:px-14 mt-6 mb-4 flex items-center justify-between">
    <h2 class="text-lg font-semibold" style="color:#C9A84C;">{{ $categoryName }}</h2>
    <span class="px-5 py-1.5 rounded-full text-sm font-semibold text-white shadow"
          style="background:#C9A84C;">
        {{ number_format($totalItems) }} Items
    </span>
</div>

{{-- ── Grid ── --}}
<section class="px-4 sm:px-14 pb-8">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

        @foreach($products as $index => $product)

            {{-- Inject Promotion Board at position $promoPosition --}}
            @if($index === $promoPosition)
            <div class="rounded-[24px] flex flex-col items-start justify-between p-5 relative overflow-hidden row-span-2"
                 style="background:linear-gradient(160deg,#FFCF6B 0%,#F5A623 100%); min-height:420px;">
                <div>
                    <p class="font-bold text-gray-800 text-lg leading-snug mb-1">Promotion<br>Board</p>
                    <p class="font-black text-gray-900 leading-none"
                       style="font-size:clamp(3rem,7vw,4.5rem);font-family:'Impact','Arial Black',sans-serif;">70%</p>
                    <p class="font-black italic text-gray-900 leading-none"
                       style="font-size:clamp(3rem,7vw,4.5rem);font-family:'Impact','Arial Black',sans-serif;">OFF</p>
                </div>
                <div class="w-full flex items-end justify-center mt-4">
                    @if(isset($promoImage))
                        <img src="{{ asset($promoImage) }}" alt="Promo" class="w-40 object-contain drop-shadow-xl">
                    @else
                        <div class="relative flex items-end justify-center w-40 h-32">
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-36 h-5 rounded-full blur-md opacity-50"
                                 style="background:linear-gradient(90deg,#C8F,#6FF,#FFF);"></div>
                            <div class="flex gap-2 relative z-10">
                                <div class="w-14 h-14 rounded-2xl bg-white/30 flex items-center justify-center">
                                    <i class="fas fa-headphones text-white text-2xl"></i>
                                </div>
                                <div class="w-10 h-16 rounded-2xl bg-white/30 flex items-center justify-center">
                                    <i class="fas fa-mobile-alt text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Last card → Next Page card --}}
            @if($loop->last && $currentPage < $totalPages)
                <a href="?page={{ $nextPage }}"
                   class="rounded-[24px] bg-[#FAF6EE] flex flex-col items-center justify-center p-4 gap-3 hover:shadow-md transition-all group border-2 border-dashed border-yellow-300 hover:border-yellow-500">

                    <div class="w-14 h-14 rounded-full flex items-center justify-center transition-transform group-hover:scale-110"
                         style="background:#C9A84C;">
                        <i class="fas fa-chevron-right text-white text-xl"></i>
                    </div>

                    <div class="text-center">
                        <p class="text-sm font-bold text-gray-700 group-hover:text-yellow-600 transition-colors">Next Page</p>
                        <p class="text-xs text-gray-400 mt-0.5">Page {{ $nextPage }} of {{ $totalPages }}</p>
                    </div>

                    <span class="px-4 py-1.5 rounded-full text-xs font-semibold text-white"
                          style="background:#C9A84C;">
                        View More →
                    </span>
                </a>

            @else
                {{-- Regular Product Card --}}
                <div class="rounded-[24px] bg-[#FAF6EE] flex flex-col items-center p-4 gap-2 hover:shadow-md transition-shadow">

                    <a href="{{ url('/product/' . $product['slug']) }}" class="w-full flex items-center justify-center h-36 sm:h-44">
                        @if($product['image'])
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="max-h-full object-contain">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-box text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </a>

                    <a href="{{ url('/product/' . $product['slug']) }}"
                       class="text-center text-xs font-semibold text-gray-700 hover:text-yellow-600 transition-colors leading-snug uppercase tracking-wide">
                        {{ $product['name'] }}<br>
                        <span class="font-normal text-gray-500">{{ $product['model'] }}</span>
                    </a>

                    <span class="px-4 py-1 rounded-full bg-gray-800 text-white text-xs font-bold">
                        ${{ number_format($product['price'], 2) }}
                    </span>

                    <button onclick="addToCart({{ $product['id'] }})"
                            class="w-full py-2.5 rounded-full text-sm font-semibold hover:brightness-95 transition-all shadow-sm"
                            style="background:#C9A84C; color:#fff;">
                        Add to Cart
                    </button>
                </div>
            @endif

        @endforeach
    </div>
</section>

{{-- ── Pagination ── --}}
<div class="flex items-center justify-center gap-1 pb-10">
    {{-- Prev dot --}}
    @if($currentPage > 1)
        <a href="?page={{ $currentPage - 1 }}"
           class="w-2.5 h-2.5 rounded-full bg-yellow-500 mx-1 hover:bg-yellow-600 transition-colors cursor-pointer"></a>
    @else
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-200 mx-1"></span>
    @endif

    @for($p = 1; $p <= $totalPages; $p++)
        @if($p == $currentPage)
            <a href="?page={{ $p }}"
               class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white shadow"
               style="background:#C9A84C;">{{ $p }}</a>
        @else
            <a href="?page={{ $p }}"
               class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium text-gray-500 hover:bg-yellow-100 transition-colors">
               {{ $p }}
            </a>
        @endif
    @endfor

    {{-- Next dot --}}
    @if($currentPage < $totalPages)
        <a href="?page={{ $nextPage }}"
           class="w-2.5 h-2.5 rounded-full bg-yellow-500 mx-1 hover:bg-yellow-600 transition-colors cursor-pointer"></a>
    @else
        <span class="w-2.5 h-2.5 rounded-full bg-yellow-200 mx-1"></span>
    @endif
</div>
@endsection

@push('scripts')
<script>
function addToCart(productId) {
    console.log('Add to cart:', productId);
}
</script>
@endpush

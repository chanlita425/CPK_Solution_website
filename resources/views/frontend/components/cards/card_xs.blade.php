
<div class="rounded-[18px] bg-[#FAF6EE] flex items-center p-8 gap-3 hover:shadow-md transition-shadow">
    <a href="{{ url('/product/'.$product['slug']) }}"
        class="flex-shrink-0 w-16 h-16 rounded-xl bg-gray-200 flex items-center justify-center overflow-hidden">
        @if($product['image'])
            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="max-h-full object-contain">
        @else
            <i class="fas fa-lock text-gray-400 text-lg"></i>
        @endif
    </a>
    <div class="flex-1 min-w-0">
        <a href="{{ url('/product/'.$product['slug']) }}">
            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide truncate">{{ $product['name'] }}</p>
            <p class="text-xs text-gray-500 truncate">{{ $product['model'] }}</p>
        </a>
        <div class="flex items-center gap-2 mt-1.5">
            <span class="px-2.5 py-0.5 rounded-full bg-gray-800 text-white text-xs font-bold whitespace-nowrap">
                ${{ number_format($product['price'], 2) }}
            </span>
            <button onclick="addToCart({{ $product['id'] }})"
                class="flex-1 py-1.5 rounded-full text-xs font-semibold text-white hover:brightness-95 transition-all"
                style="background:#C9A84C;">Add to Cart
            </button>
        </div>
        
    </div>
</div>
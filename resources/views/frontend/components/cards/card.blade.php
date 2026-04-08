
<div class="rounded-[20px] bg-[#FAF6EE] flex flex-col items-center p-4 gap-2 hover:shadow-md transition-shadow">
    <a href="{{ url('/product/'.$product['slug']) }}"
        class="w-full flex items-center justify-center h-36 sm:h-40">
        @if($product['image'])
            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="max-h-full object-contain">
        @else
            <div class="w-20 h-20 rounded-2xl bg-gray-200 flex items-center justify-center">
                <i class="fas fa-lock text-gray-400 text-3xl"></i>
            </div>
        @endif
    </a>

    <a href="{{ url('/product/'.$product['slug']) }}"
        class="text-center text-xs font-bold text-gray-700 hover:text-yellow-600 transition-colors leading-snug uppercase tracking-wide">
        {{ $product['name'] }}<br>
        <span class="font-normal text-gray-500 normal-case">{{ $product['model'] }}</span>
    </a>

    <span class="px-4 py-1 rounded-full bg-gray-800 text-white text-xs font-bold">
        ${{ number_format($product['price'], 2) }}
    </span>
    
    <button onclick="addToCart({{ $product['id'] }})"
            class="w-full py-2.5 rounded-full text-sm font-semibold hover:brightness-95 transition-all"
            style="background:#C9A84C; color:#fff;">Add to Cart
    </button>
</div>
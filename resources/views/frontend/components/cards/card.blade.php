<a href="{{ route('pages.viewProduct', $product->id) }}" class="block">
    <div class="rounded-[20px] bg-[#FAF6EE] flex flex-col items-center p-4 gap-2 hover:shadow-md transition-shadow">

        {{-- Product Image --}}
        <div class="w-full flex items-center justify-center h-36 sm:h-40">
            @if($product->mainImage && $product->mainImage->image)
                <img src="{{ asset('storage/' . $product->mainImage->image) }}" 
                    alt="{{ $product->name_en }}" 
                    class="max-h-full object-contain">
            @else
                <div class="w-20 h-20 rounded-2xl bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-lock text-gray-400 text-3xl"></i>
                </div>
            @endif
        </div>

        {{-- Product Name & SKU --}}
        <div class="text-center text-xs font-bold text-black hover:text-yellow-600 transition leading-snug uppercase">
            {{ $product->name_en }} <br>
            <span class="normal-case">{{ $product->SKU }}</span>
        </div>

        {{-- Price --}}
        <span class="px-4 py-1 rounded-full bg-gray-800 text-white text-xs font-bold">
            ${{ number_format($product->price, 2) }}
        </span>

        {{-- Add to Cart --}}
        <button type="button" onclick="event.stopPropagation(); addToCart({{ $product->id }})"
            class="w-full py-2.5 rounded-[18px] font-bold bg-[#D7B259] hover:brightness-95 transition">
            Add to Cart
        </button>

    </div>
</a>
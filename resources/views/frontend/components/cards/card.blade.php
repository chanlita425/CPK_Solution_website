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
       <form action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="event.stopPropagation();">
            @csrf

            <button type="submit"
                class="w-full sm:w-auto px-4 sm:px-14 py-2 rounded-full text-sm sm:text-base font-semibold text-black hover:brightness-95 transition-all shadow-md active:scale-95"
                style="background:#C9A84C;">
                Add to Cart
            </button>
        </form>

    </div>
</a>
<div class="block">
    <div class="rounded-[20px] bg-[#FAF6EE] flex flex-col items-center h-full p-4 gap-2 hover:shadow-md transition-shadow">

        {{-- Product Image --}}
        <a href="{{ route('pages.viewProduct', $product->id) }}#product-detail" class="w-full flex items-center justify-center h-36 sm:h-40">
            @if($product->mainImage && $product->mainImage->image)
                <img src="{{ asset('storage/' . $product->mainImage->image) }}" 
                    alt="{{ $product->name }}"
                    class="max-h-full object-contain">
            @else
                <div class="w-20 h-20 rounded-2xl bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-lock text-gray-400 text-3xl"></i>
                </div> 
            @endif 
        </a>

        {{-- Product Name & SKU --}}
        <a href="{{ route('pages.viewProduct', $product->id) }}#product-detail" class="text-center text-xs font-bold text-black hover:text-yellow-600 transition leading-snug uppercase">
            {{ $product->name }} <br> 
        </a>

        {{-- Price --}}
        <span class="px-4 py-1 rounded-full bg-gray-800 text-white text-xs font-bold">
            ${{ number_format($product->price, 2) }}
        </span>

        {{-- Buttons --}}
        <div class="w-full flex flex-row gap-2 mt-auto">

            {{-- Detail Button --}}
            <a href="{{ route('pages.viewProduct', $product->id) }}#product-detail"
                class="flex-1 flex items-center justify-center py-2 px-2 rounded-full text-xs md:text-sm font-semibold text-black hover:brightness-95 transition-all shadow-md active:scale-95 whitespace-nowrap"
                style="background:#C9A84C;">
                {{ __('messages.details') }}
            </a>

            {{-- Add to Cart (AJAX) --}}
            <button type="button"
                onclick="addToCartAjax('{{ route('cart.add', $product->id) }}', this)"
                class="flex-1 flex items-center justify-center py-2 px-2 rounded-full text-xs md:text-sm font-semibold text-black hover:brightness-95 transition-all shadow-md active:scale-95 whitespace-nowrap"
                style="background:#C9A84C;">
                {{ __('messages.add_to_cart') }}
            </button>

        </div>

    </div>
</div>
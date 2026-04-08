        

    <div class="w-full lg:w-1/2 flex flex-col gap-3 sm:gap-4">

        {{-- Name --}}
        <h1 class="text-base sm:text-lg lg:text-xl font-bold text-gray-800 leading-snug">
            {{ $product['name'] }}
        </h1>

        {{-- Meta --}}
        <div class="flex flex-col gap-1 text-xs sm:text-sm text-gray-500">
            <p>Brand: <span class="text-gray-700 font-medium">{{ $product['brand'] }}</span></p>
            <p>SKU: <span class="text-gray-700 font-medium">{{ $product['sku'] }}</span></p>
        </div>

        {{-- Price --}}
        <p class="text-lg sm:text-xl font-bold" style="color:#C9A84C;">
            ${{ number_format($product['price'], 2) }}
        </p>

        {{-- Specifications --}}
        <div>
            <p class="text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Specification:</p>
            <ul class="space-y-0.5">
                @foreach($product['specs'] as $spec)
                <li class="flex items-start gap-1.5 text-xs sm:text-sm text-gray-600">
                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                    {{ $spec }}
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Quantity --}}
        <div class="flex flex-col xs:flex-col sm:flex-row items-center sm:items-start gap-2 sm:gap-3 text-md sm:text-[20px] text-gray-700">
            <span class="font-medium text-center sm:text-left">Quantity</span>

            <div class="flex items-center gap-1 sm:gap-2">
                <button onclick="changeQty(-1)"
                        class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors text-base sm:text-base md:text-lg leading-none">
                    -
                </button>

                <span id="qty-display" class="w-8 sm:w-10 md:w-12 text-center font-semibold text-sm sm:text-base md:text-lg">
                    1
                </span>

                <button onclick="changeQty(1)"
                        class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors text-base sm:text-base md:text-lg leading-none">
                    +
                </button>
            </div>
        </div>

        {{-- Add to Cart --}}
        <div class="pt-2">
            <button onclick="addToCart({{ $product['id'] }})"
                    class="w-full sm:w-auto px-2 py-2 rounded-full text-sm sm:text-base font-semibold text-white hover:brightness-95 transition-all shadow-md active:scale-95"
                    style="background:#C9A84C;">
                Add to Cart
            </button>
        </div>
        
    </div>  
        
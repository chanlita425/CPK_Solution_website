<div class="w-full lg:w-1/2 flex flex-col gap-3 sm:gap-4">

    {{-- Name --}}
    <h1 class="text-base sm:text-lg lg:text-xl font-bold text-gray-800 leading-snug">
        {{ $product->name_en }}
    </h1>

    {{-- Meta --}}
    <div class="flex flex-col gap-1 text-xs sm:text-sm text-gray-500">

        <p>
            Brand:
            <span class="text-gray-700 font-medium">
                {{ $product->brand->name ?? 'N/A' }}
            </span>
        </p>

        <p>
            SKU:
            <span class="text-gray-700 font-medium">
                {{ $product->sku ?? 'N/A' }}
            </span>
        </p>

    </div>

    {{-- Price --}}
    <p class="text-lg sm:text-xl font-bold" style="color:#C9A84C;">
        ${{ number_format($product->price, 2) }}
    </p>

    {{-- Specifications --}}
    <div>
        <p class="text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            Specification:
        </p>

        @php
            // STEP 1: take raw text
            $raw = $product->specification_en ?? '';

            // STEP 2: split by NEW LINE (Enter)
            $specs = preg_split("/\r\n|\n|\r/", trim($raw));

            // STEP 3: remove empty lines
            $specs = array_filter($specs);
        @endphp

        @if(count($specs))
            <ul class="space-y-1">
                @foreach($specs as $spec)
                    <li class="text-xs sm:text-sm text-black flex gap-1">
                        <span class="text-gray-600">.</span>
                        <span>{{ trim($spec) }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-xs text-gray-400">No specification available</p>
        @endif
    </div>

    {{-- Quantity --}}
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-2 sm:gap-3 text-md sm:text-[20px] text-gray-700">

        <span class="font-medium text-center sm:text-left">
            Quantity
        </span>

        <div class="flex items-center gap-1 sm:gap-2">

            <button onclick="changeQty(-1)"
                class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition">
                -
            </button>

            <span id="qty-display"
                class="w-8 sm:w-10 md:w-12 text-center font-semibold text-sm sm:text-base md:text-lg">
                1
            </span>

            <button onclick="changeQty(1)"
                class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition">
                +
            </button>

        </div>
    </div>

    {{-- Add to Cart --}}
    <div class="pt-2">
        <form action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="event.stopPropagation();">
            @csrf

            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 rounded-full text-sm sm:text-base font-semibold text-black hover:brightness-95 transition-all shadow-md active:scale-95"
                style="background:#C9A84C;">
                Add to Cart
            </button>
        </form>
    </div>


</div>
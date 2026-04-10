    
    
    <div class="w-full lg:w-1/3 flex flex-col gap-4 mx-auto ">

        {{---- Main image ----}}
        <div class="w-full rounded-2xl bg-gray-50 border border-gray-400 flex items-center justify-center
            aspect-square sm:aspect-[4/3] lg:aspect-square overflow-hidden">

           @php
            $mainImage = $product->images->first();
        @endphp

        @if($mainImage && $mainImage->image)
            <img id="mainImage"
                src="{{ asset('storage/' . $mainImage->image) }}"
                alt="{{ $product->name_en }}"
                class="w-full h-full object-contain p-6 sm:p-10">
        @else
            <div class="flex flex-col items-center gap-2 text-gray-300">
                <i class="fas fa-image text-5xl sm:text-6xl"></i>
                <span class="text-xs">No image</span>
            </div>
        @endif
        </div>

        {{---- Thumbnail ----}}
        <div class="grid grid-cols-3 gap-2 sm:gap-3">
             @foreach($product->images->skip(1) as $thumb)
            <button
                onclick="selectThumb('{{ asset('storage/' . $thumb->image) }}')"
                class="aspect-square rounded-xl border-2 overflow-hidden flex items-center justify-center bg-gray-50
                border-gray-200 hover:border-yellow-300">

                <img src="{{ asset('storage/' . $thumb->image) }}"
                    class="w-full h-full object-contain ">
            </button>
        @endforeach
        </div>

    </div>
    



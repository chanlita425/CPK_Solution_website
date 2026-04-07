    
    
    <div class="w-full lg:w-1/3 flex flex-col gap-4 mx-auto ">

        {{---- Main image ----}}
        <div class="w-full rounded-2xl bg-gray-50 border border-gray-400 flex items-center justify-center
            aspect-square sm:aspect-[4/3] lg:aspect-square overflow-hidden">

            @if($product['image'])
                <img src="{{ asset($product['image']) }}"
                    alt="{{ $product['name'] }}"
                    class="w-full h-full object-contain p-6 sm:p-10">
            @else
                <div class="flex flex-col items-center gap-2 text-gray-300">
                    <i class="fas fa-image text-5xl sm:text-6xl"></i>
                    <span class="text-xs">No image</span>
                </div>
            @endif
        </div>

        {{---- Thumbnail ----}}
        <div class="grid grid-cols-4 gap-2 sm:gap-3">
            @foreach($product['gallery'] as $i => $thumb)
                <button onclick="selectThumb({{ $i }})"
                        class="thumb-btn aspect-square rounded-xl border-2 transition-all duration-200 overflow-hidden flex items-center justify-center bg-gray-50
                            {{ $i === 0 ? 'border-yellow-400' : 'border-gray-200 hover:border-yellow-300' }}">
                    @if($thumb)
                        <img src="{{ asset($thumb) }}" alt="Gallery {{ $i+1 }}"
                            class="w-full h-full object-contain p-2">
                    @else
                        <div class="w-full h-full bg-gray-100"></div>
                    @endif
                </button>
            @endforeach
        </div>

    </div>
    
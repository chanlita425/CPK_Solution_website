<div class="w-full lg:w-1/3 flex flex-col gap-4 mx-auto">

    {{---- Main image ----}}
    <div class="w-full rounded-2xl bg-gray-50 border border-gray-400 flex items-center justify-center
        aspect-square sm:aspect-[4/3] lg:aspect-square overflow-hidden">

        @php
            $mainImage = $thumbnails[0]['url'] ?? null;
        @endphp

        @if($mainImage)
            <img id="mainImage"
                src="{{ $mainImage }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-contain p-6 sm:p-10">
        @else
            <div class="flex flex-col items-center gap-2 text-gray-300">
                <i class="fas fa-image text-5xl sm:text-6xl"></i>
                <span class="text-xs">No image</span>
            </div>
        @endif
    </div>

    {{---- Thumbnail - ALWAYS 4 boxes ----}}
    <div class="grid grid-cols-4 gap-2 sm:gap-3">
        @foreach($thumbnails as $index => $thumb)
            @if($thumb['url'])
                <button
                    onclick="selectThumb('{{ $thumb['url'] }}', {{ $index }})"
                    class="thumb-btn aspect-square rounded-xl border-2 overflow-hidden flex items-center justify-center bg-gray-50
                    {{ $index === 0 ? 'border-yellow-400' : 'border-gray-200' }}
                    hover:border-yellow-300 transition-all">
                    <img src="{{ $thumb['url'] }}"
                        alt="Thumbnail {{ $index + 1 }}"
                        class="w-full h-full object-contain p-2">
                </button>
            @else
                {{-- Placeholder for missing images --}}
                <div class="aspect-square rounded-xl border-2 border-gray-200 overflow-hidden flex items-center justify-center bg-gray-100">
                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                </div>
            @endif
        @endforeach
    </div>

</div>

<script>
    const originalMainSrc = document.getElementById('mainImage')?.src;
    let activeThumbIndex = 0;

    function selectThumb(imageUrl, index) {
        const mainImage = document.getElementById('mainImage');
        const thumbs = document.querySelectorAll('.thumb-btn');

        if (!mainImage) return;

        // Update main image
        mainImage.style.opacity = 0;
        setTimeout(() => {
            mainImage.src = imageUrl;
            mainImage.style.opacity = 1;
        }, 120);

        activeThumbIndex = index;

        // Update active state on thumbnails
        thumbs.forEach((btn, i) => {
            btn.classList.toggle('border-yellow-400', i === activeThumbIndex);
            btn.classList.toggle('border-gray-200', i !== activeThumbIndex);
        });
    }
</script>

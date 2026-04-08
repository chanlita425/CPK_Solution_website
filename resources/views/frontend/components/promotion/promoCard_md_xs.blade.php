


<!-- Promotion Card md -> xs -->
<div class="lg:hidden px-4 sm:px-8 mb-5">
    <div class="rounded-[24px] overflow-hidden relative flex items-center justify-between px-6 py-5 gap-4"
         style="background:linear-gradient(135deg,#FFCF6B 0%,#F5A623 60%,#E8940A 100%); min-height:120px;">
        
        <div class="absolute -top-6 -right-6 w-28 h-28 rounded-full opacity-20" style="background:#fff;"></div>
        <div class="absolute -bottom-8 -left-4 w-20 h-20 rounded-full opacity-15" style="background:#fff;"></div>

        <div class="flex-1 z-10">
            <p class="font-bold text-amber-900 uppercase tracking-[.18em] mb-1" style="font-size:9px;">Limited Time Only</p>
            <p class="font-black text-gray-900 leading-none"
               style="font-size:clamp(2rem,9vw,3rem);font-family:'Impact','Arial Black',sans-serif;letter-spacing:-1px;">
               70% <span class="italic">OFF</span>
            </p>
            <p class="text-xs font-semibold text-amber-900 mt-1">Promotion Board</p>
            <a href="{{ $promoUrl ?? '#' }}"
               class="inline-block mt-3 px-5 py-1.5 rounded-full text-xs font-bold text-white shadow hover:brightness-95 transition-all"
               style="background:#7C4F00;">Shop Now →</a>
        </div>

        <div class="flex-shrink-0 flex items-end justify-center z-10" style="width:clamp(80px,20vw,130px)">
            @if(isset($promoImage))
                <img src="{{ asset($promoImage) }}" alt="Promo" class="w-full object-contain drop-shadow-xl">
            @else
                <div class="flex gap-2 items-end">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background:rgba(255,255,255,.28)">
                        <i class="fas fa-headphones text-white text-lg"></i>
                    </div>
                    <div class="w-9 h-14 rounded-2xl flex items-center justify-center" style="background:rgba(255,255,255,.28)">
                        <i class="fas fa-mobile-alt text-white"></i>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>


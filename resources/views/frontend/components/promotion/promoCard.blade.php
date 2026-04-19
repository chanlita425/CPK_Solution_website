{{-- <div class="rounded-[24px] flex flex-col justify-between p-5 relative overflow-hidden row-span-2"
   style="background:linear-gradient(135deg,#FFCF6B 0%,#e5c085 60%,#edb356 100%);  min-height:420px;">
    
    <div class="absolute -top-8 -right-8 w-36 h-36 rounded-full opacity-20" style="background:#fff;"></div>
    
    <div class="relative z-10">
        <p class="font-bold text-amber-900 uppercase tracking-[.15em] mb-1" style="font-size:9px;">Limited Time</p>
        <p class="text-lg font-bold text-gray-800 leading-snug">Promotion<br>Board</p>
        <p class="font-black text-gray-900 leading-none mt-2"
            style="font-size:clamp(3rem,4.5vw,4rem);font-family:'Impact','Arial Black',sans-serif;">70%</p>
        <p class="font-black italic text-gray-900 leading-none"
            style="font-size:clamp(3rem,4.5vw,4rem);font-family:'Impact','Arial Black',sans-serif;">OFF</p>
        <a href="{{ $promoUrl ?? '#' }}"
            class="inline-block mt-4 px-5 py-1.5 rounded-full text-xs font-bold text-white shadow hover:brightness-95 transition-all"
            style="background:#7C4F00;">Shop Now →</a>
    </div>
    
    <div class="flex justify-center z-10 mt-4">
        @if(isset($promoImage))
            <img src="{{ asset($promoImage) }}" alt="Promo" class="w-36 object-contain drop-shadow-xl">
        @else
            <div class="flex gap-2 items-end">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:rgba(255,255,255,.28)">
                    <i class="fas fa-headphones text-white text-2xl"></i>
                </div>
                <div class="w-10 h-16 rounded-2xl flex items-center justify-center" style="background:rgba(255,255,255,.28)">
                    <i class="fas fa-mobile-alt text-white text-xl"></i>
                </div>
            </div>
        @endif
    </div>

</div> --}}

{{-- <div class="rounded-[24px] overflow-hidden row-span-2 relative" style="min-height:420px;">
    <img src="{{ asset('storage/' . $promoImage) }}" 
         alt="Promo" 
         class="w-full h-full object-cover">
</div> --}}

<div class="row-span-2 h-full rounded-[24px] overflow-hidden">
    <img src="{{ asset('storage/' . $promoImage) }}"
         class="w-full h-full object-cover">
</div>

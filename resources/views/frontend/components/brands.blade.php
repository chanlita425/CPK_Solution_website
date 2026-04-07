@php
$brands = $brands ?? [
    ['logo' => 'icold.png',    'slug' => 'icold'],
    ['logo' => 'lg.png',       'slug' => 'lg'],
    ['logo' => 'sanden.png',   'slug' => 'sanden',  'active' => true],
    ['logo' => 'samsung.png',  'slug' => 'samsung'],
    ['logo' => 'panasonic.png','slug' => 'panasonic'],
    ['logo' => 'sharp.png',    'slug' => 'sharp'],
    ['logo' => 'toshiba.png',  'slug' => 'toshiba'],
    ['logo' => 'midea.png',    'slug' => 'midea'],
    ['logo' => 'lsr.png',      'slug' => 'lsr'],
    ['logo' => 'alaska.png',   'slug' => 'alaska'],
    ['logo' => 'khind.png',    'slug' => 'khind'],
    ['logo' => 'icold.png',    'slug' => 'icold'],
    ['logo' => 'lg.png',       'slug' => 'lg'], 
    ['logo' => 'samsung.png',  'slug' => 'samsung'],
    ['logo' => 'panasonic.png','slug' => 'panasonic'],
    ['logo' => 'sharp.png',    'slug' => 'sharp'],
    ['logo' => 'toshiba.png',  'slug' => 'toshiba'],
    ['logo' => 'midea.png',    'slug' => 'midea'],
    ['logo' => 'lsr.png',      'slug' => 'lsr'],
    ['logo' => 'alaska.png',   'slug' => 'alaska'],
    ['logo' => 'khind.png',    'slug' => 'khind'],
];
@endphp

<section class="px-8 mt-2">
    <div class="relative bg-[#FCF6ED] rounded-[40px] px-6 py-5">

        {{-- Label --}}
        <p class="text-center text-xs font-semibold text-[#000000] uppercase tracking-widest mb-4">Brands</p>

        {{-- Swiper --}}
        <div class="swiper brands-swiper overflow-hidden">
            <div class="swiper-wrapper flex items-center">
                @foreach($brands as $brand)
                <div class="swiper-slide !w-auto">
                    <a href="{{ url('/brand/' . $brand['slug']) }}"
                       class="flex items-center justify-center px-4 py-2 rounded-full transition-all duration-200
                              {{ !empty($brand['active']) ? 'bg-[#F5C842] shadow-md' : 'hover:bg-[#FFE3A1]' }}">
                        @if(!empty($brand['logo']))
                            <img
                                src="{{ asset('images/' . $brand['logo']) }}"
                                alt="{{ $brand['slug'] }}"
                                class="h-8 w-auto object-contain max-w-[90px]"
                            >
                        @else
                            <span class="font-bold text-sm text-gray-500 uppercase tracking-wide">
                                {{ $brand['slug'] }}
                            </span>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Prev button --}}
        <button class="brand-prev absolute left-3 top-1/2 -translate-y-1/2 z-10
            w-8 h-8 flex items-center justify-center
            text-gray-400 hover:text-yellow-500 transition-all">
          
        </button>

        {{-- Next button --}}
        <button class="brand-next absolute right-3 top-1/2 -translate-y-1/2 z-10
            w-8 h-8 flex items-center justify-center
            text-gray-400 hover:text-yellow-500 transition-all">
        </button>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandSwiper = new Swiper('.brands-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 8,
        grabCursor: true,
        freeMode: true,
        navigation: {
            nextEl: '.brand-next',
            prevEl: '.brand-prev',
        },
        on: {
            init: function () {
                const wrapperWidth  = this.wrapperEl.scrollWidth;
                const containerWidth = this.el.clientWidth;
                const hide = wrapperWidth <= containerWidth;
                this.navigation.prevEl.style.display = hide ? 'none' : '';
                this.navigation.nextEl.style.display = hide ? 'none' : '';
            }
        }
    });
});
</script>
@endpush
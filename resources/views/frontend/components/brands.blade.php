@php
    use App\Models\Brand;
    $brands = Brand::where('is_active', true)->get();
@endphp

<section class="px-8 mt-2">
    <div class="relative bg-[#FCF6ED] rounded-[40px] shadow-sm border border-gray-100 p-14 py-6">
        <p class="text-center text-xs font-semibold text-[#000000] uppercase tracking-widest mb-4">
            {{ __('messages.brands') }}</p>

        {{-- Swiper --}}
        <div class="swiper brands-swiper overflow-hidden">
            <div class="swiper-wrapper">
                @foreach ($brands as $index => $brand)
                    <div class="swiper-slide !w-auto">
                        <a href="#" data-brand-id="{{ $brand->id }}"
                            class="brand-filter-link flex items-center justify-center px-4 py-3 rounded-full transition-all duration-200
                            {{ ($brandId ?? null) == $brand->id ? 'bg-[#FFE3A1]' : 'hover:bg-[#FFE3A1]' }}">

                            @if ($brand->logo_image)
                                <img src="{{ asset('storage/' . $brand->logo_image) }}" alt="{{ $brand->name }}"
                                    class="h-8 w-auto object-contain max-w-[90px]">
                            @else
                                <span class="font-bold text-sm text-gray-500 uppercase tracking-wide">
                                    {{ $brand->name }}
                                </span>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Nav buttons (SAME STYLE AS CATEGORIES) --}}
        <button id="brand-prev"
            class="brand-prev pt-6 absolute left-6 top-1/2 -translate-y-1/2 -translate-x-3 z-10 w-7 h-7 flex items-center justify-center hover:opacity-70 transition-all">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19" />
                <rect x="14" y="5" width="3" height="14" rx="1" />
            </svg>
        </button>
        <button id="brand-next"
            class="brand-next pt-6 absolute right-6 top-1/2 -translate-y-1/2 translate-x-3 z-10 w-7 h-7 flex items-center justify-center hover:opacity-70 transition-all">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19" />
                <rect x="7" y="5" width="3" height="14" rx="1" />
            </svg>
        </button>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brandSwiperEl = document.querySelector('.brands-swiper');
            const brandPrevBtn = document.getElementById('brand-prev');
            const brandNextBtn = document.getElementById('brand-next');

            if (brandSwiperEl) {
                const brandSwiper = new Swiper(brandSwiperEl, {
                    slidesPerView: 'auto',
                    spaceBetween: 8,
                    navigation: {
                        nextEl: brandNextBtn,
                        prevEl: brandPrevBtn,
                    },
                    grabCursor: true,
                    freeMode: true,
                    on: {
                        init: function() {
                            const wrapperWidth = this.wrapperEl.scrollWidth;
                            const containerWidth = this.el.clientWidth;
                            const showButtons = wrapperWidth > containerWidth;
                            if (brandPrevBtn) brandPrevBtn.style.display = showButtons ? 'flex' :
                            'none';
                            if (brandNextBtn) brandNextBtn.style.display = showButtons ? 'flex' :
                            'none';
                        },
                        resize: function() {
                            const wrapperWidth = this.wrapperEl.scrollWidth;
                            const containerWidth = this.el.clientWidth;
                            const showButtons = wrapperWidth > containerWidth;
                            if (brandPrevBtn) brandPrevBtn.style.display = showButtons ? 'flex' :
                            'none';
                            if (brandNextBtn) brandNextBtn.style.display = showButtons ? 'flex' :
                            'none';
                        }
                    }
                });
            }
        });
    </script>
@endpush

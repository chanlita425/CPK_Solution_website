@php
    use App\Models\Category;
@endphp

<section class="category px-8">
    <div class="relative bg-[#FFEDD0] rounded-[40px] shadow-sm border border-gray-100 p-14 py-6">
        <p class="text-center text-xs font-Inter text-[#000000] uppercase tracking-widest mb-3">{{ __('messages.categories') }}</p>

        {{-- Swiper --}}
        <div class="swiper categories-swiper overflow-hidden">
            <div class="swiper-wrapper">

                 @foreach($categories as $index => $cat)
                    <div class="swiper-slide !w-auto">
                        @php $baseUrl = $filterBaseUrl ?? url()->current(); @endphp
                        <a href="{{ $categoryId == $cat->id
                                ? $baseUrl . ($brandId ? '?brand_id=' . $brandId : '') . (request('search') ? ($brandId ? '&' : '?') . 'search=' . request('search') : '') . '#product-grid'
                                : $baseUrl . '?category_id=' . $cat->id . ($brandId ? '&brand_id=' . $brandId : '') . (request('search') ? '&search=' . request('search') : '') . '#product-grid'
                            }}"
                            data-filter-link="category"
                            data-cat-id="{{ $cat->id }}"
                        class="flex flex-col items-center gap-3 px-3 py-3 hover:bg-primary-50 rounded-xl transition-colors group w-30 text-center
                        {{ $categoryId == $cat->id ? 'bg-[#FFE3A1] shadow-sm' : '' }}">
                            
                            <div class="w-14 h-14 bg-white group-hover:bg-primary-100 rounded-xl flex items-center justify-center transition-colors shadow-sm">
                                @if($cat->icon_url)
                                    <img src="{{ asset($cat->icon_url) }}" alt="{{ $cat->name }}" class="w-8 h-8 object-contain">
                                @else
                                    <i class="fa fa-folder text-primary-600 text-base"></i>
                                @endif
                            </div>

                            <span class="text-[10px] font-medium text-gray-600 group-hover:text-primary-700 leading-tight transition-colors">
                                {{ $cat->name }}
                            </span>
                        </a>
                    </div>
                @endforeach
                
            </div>
        </div>

        {{-- Nav buttons --}}
        <button id="cat-prev" class="cat-prev absolute left-6 top-1/2 -translate-y-1/2 -translate-x-3 z-10 w-7 h-7 flex items-center justify-center hover:shadow-lg transition-all">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="5,12 14,5 14,19"/>
                <rect x="14" y="5" width="3" height="14" rx="1"/>
            </svg>        
        </button>
        <button id="cat-next" class="cat-next absolute right-6 top-1/2 -translate-y-1/2 translate-x-3 z-10 w-7 h-7 flex items-center justify-center hover:shadow-lg transition-all">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="#C9A84C" xmlns="http://www.w3.org/2000/svg">
                <polygon points="19,12 10,5 10,19"/>
                <rect x="7" y="5" width="3" height="14" rx="1"/>
            </svg>
        </button>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiperEl = document.querySelector('.categories-swiper');
        const prevBtn = document.getElementById('cat-prev');
        const nextBtn = document.getElementById('cat-next');

        const categorySwiper = new Swiper(swiperEl, {
            slidesPerView: 'auto',
            spaceBetween: 4,
            navigation: {
                nextEl: nextBtn,
                prevEl: prevBtn,
            },
            grabCursor: true,
            freeMode: true,
            on: {
                init: function () {
                    const wrapperWidth   = this.wrapperEl.scrollWidth;
                    const containerWidth = this.el.clientWidth;
                    const showButtons    = wrapperWidth > containerWidth;
                    prevBtn.style.display = showButtons ? 'flex' : 'none';
                    nextBtn.style.display = showButtons ? 'flex' : 'none';
                },
                resize: function () {
                    const wrapperWidth   = this.wrapperEl.scrollWidth;
                    const containerWidth = this.el.clientWidth;
                    const showButtons    = wrapperWidth > containerWidth;
                    prevBtn.style.display = showButtons ? 'flex' : 'none';
                    nextBtn.style.display = showButtons ? 'flex' : 'none';
                }
            }
        });
    });
</script>
@endpush 
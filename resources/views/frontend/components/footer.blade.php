@php
    use App\Models\Category;

    $settings = \App\Models\Setting::getSettings();

    $categories = Category::where('is_active', true)
                        ->take(8)
                        ->get();
@endphp

<footer class="bg-[#28282A] text-white mt-12">
    <div class="bg-[#D7B259] text-gray-300 text-xs p-4"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- ================= About Company ================= --}}
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-4 mb-4">
                    
                    {{-- Logo --}}
                    @if(!empty($settings->logo))
                        <img src="{{ asset('storage/' . $settings->logo) }}" 
                            alt="Logo"
                            class="h-12 w-auto object-contain">
                    @else
                        <img src="{{ asset('images/logo.png') }}" 
                            alt="Default Logo"
                            class="h-12 w-auto object-contain">
                    @endif

                </a>

                {{-- Description --}}
                <p class="text-[18px] leading-relaxed text-gray-300">
                    {{ $settings->about_company ?? 'Your trusted partner for home appliances, electronics, and smart solutions in Cambodia.' }}
                </p>
            </div>

            {{-- ================= CATEGORIES ================= --}}
            <div>
                <h4 class="text-[#D7B259] font-semibold text-[20px] mb-4 uppercase tracking-wide">
                    Categories
                </h4>

                <ul class="grid grid-cols-1 gap-2 text-[16px]">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ url()->current() }}?category_id={{ $cat->id }}{{ request('brand_id') ? '&brand_id=' . request('brand_id') : '' }}#product-grid"
                            class="hover:text-primary-400 transition-colors duration-200
                                    {{ request('category_id') == $cat->id ? 'text-primary-500 font-semibold' : '' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- ================= SOCIAL + CONTACT ================= --}}
            <div>
                <h4 class="text-[#D7B259] font-semibold text-[20px] mb-4 uppercase tracking-wide">
                    Follow Us
                </h4>

                {{-- Social Icons --}}
                <div class="flex items-center gap-3 mb-6">
                    @if($settings->facebook_link)
                        <a href="{{ $settings->facebook_link }}" target="_blank"
                            class="w-9 h-9 flex items-center justify-center rounded-full 
                                bg-white text-black border border-gray-300 
                                hover:bg-gray-100 hover:scale-110 hover:shadow-lg 
                                transition-all duration-200">
                            <i class="fa-brands fa-facebook-f text-lg"></i>
                        </a>
                    @endif

                    @if($settings->tiktok_link)
                        <a href="{{ $settings->tiktok_link }}" target="_blank"
                            class="w-9 h-9 flex items-center justify-center rounded-full 
                                bg-white text-black border border-gray-300 
                                hover:bg-gray-100 hover:scale-110 hover:shadow-lg 
                                transition-all duration-200">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </a>
                    @endif

                    @if($settings->instagram_link)
                        <a href="{{ $settings->instagram_link }}" target="_blank"
                            class="w-9 h-9 flex items-center justify-center rounded-full 
                                bg-white text-black border border-gray-300 
                                hover:bg-gray-100 hover:scale-110 hover:shadow-lg 
                                transition-all duration-200">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                    @endif

                    @if($settings->telegram_link)
                        <a href="{{ $settings->telegram_link }}" target="_blank"
                            class="w-9 h-9 flex items-center justify-center rounded-full 
                                bg-white text-black border border-gray-300 
                                hover:bg-gray-100 hover:scale-110 hover:shadow-lg 
                                transition-all duration-200">
                            <i class="fa-brands fa-telegram text-lg"></i>
                        </a>
                    @endif
                </div>

                {{-- Contact Info --}}
                {{-- <div class="text-[16px] space-y-2 text-gray-300">
                    
                    @if($settings->company_phone_number_first)
                        <p class="flex items-center gap-2">
                            <i class="fa fa-phone text-primary-500 text-xs"></i>
                            <a href="tel:{{ $settings->company_phone_number_first }}" 
                                class="hover:text-primary-400 transition">
                                {{ $settings->company_phone_number_first }}
                            </a>
                        </p>
                    @endif

                    @if($settings->company_phone_number_second)
                        <p class="flex items-center gap-2">
                            <i class="fa fa-phone text-primary-500 text-xs"></i>
                            <a href="tel:{{ $settings->company_phone_number_second }}" 
                                class="hover:text-primary-400 transition">
                                {{ $settings->company_phone_number_second }}
                            </a>
                        </p>
                    @endif

                    <p class="flex items-center gap-2">
                        <i class="fa fa-globe text-primary-500 text-xs"></i>
                        <a href="{{ $settings->company_url ?? '#' }}" 
                            class="hover:text-primary-400 transition">
                            {{ $settings->company_url ? (parse_url($settings->company_url, PHP_URL_HOST) ?? $settings->company_url) : 'www.cpksolution.com' }}
                        </a>
                    </p>

                </div> --}}
            </div>

        </div>

       

    </div>
</footer>
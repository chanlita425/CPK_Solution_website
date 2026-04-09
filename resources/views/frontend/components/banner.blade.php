@php
    $settings = \App\Models\Setting::getSettings();
@endphp

<section class="category px-8 sm:px-8 my-2">
    <div class="relative">

        <!-- Banner -->
        <a href="{{ url('/') }}">
            <img src="{{ asset('storage/' . ($settings->hero_banner_image ?? 'images/banner.jpg')) }}"
                 alt="Banner"
                 class="rounded-[37px] w-full h-[250px] sm:h-[300px] md:h-[460px] object-inline">
        </a>

        <!-- Social Icons -->
        <div class="hidden sm:flex flex-col gap-2 sm:gap-1
                    absolute left-4 sm:left-2 top-1/2 -translate-y-1/2
                    p-2 sm:p-3 rounded-[24px] bg-white shadow-md z-10">

            @if($settings->facebook_link)
                <a href="{{ $settings->facebook_link }}"
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#D7B259]
                          hover:bg-[#c9a24c] transition
                          flex items-center justify-center">
                    <i class="fa-brands fa-facebook-f text-white text-xs sm:text-sm leading-none"></i>
                </a>
            @endif

            @if($settings->tiktok_link)
                <a href="{{ $settings->tiktok_link }}"
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#D7B259]
                          hover:bg-[#c9a24c] transition
                          flex items-center justify-center">
                    <i class="fa-brands fa-tiktok text-white text-xs sm:text-sm leading-none"></i>
                </a>
            @endif

            @if($settings->instagram_link)
                <a href="{{ $settings->instagram_link }}"
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#D7B259]
                          hover:bg-[#c9a24c] transition
                          flex items-center justify-center">
                    <i class="fa-brands fa-instagram text-white text-xs sm:text-sm leading-none"></i>
                </a>
            @endif

            @if($settings->telegram_link)
                <a href="{{ $settings->telegram_link }}"
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#D7B259]
                          hover:bg-[#c9a24c] transition
                          flex items-center justify-center">
                    <i class="fa-brands fa-telegram text-white text-xs sm:text-sm leading-none"></i>
                </a>
            @endif

        </div>

    </div>
</section>
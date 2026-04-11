{{-- resources/views/components/header.blade.php --}}
@php
    $settings = \App\Models\Setting::getSettings();
@endphp

<div class="bg-gray-800 text-gray-300 text-xs py-1.5 px-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        {{-- Left: contact info --}}
        <div class="flex items-center gap-4 text-sm">
            {{-- Website: hidden on mobile --}}
            @if($settings->company_url)
                <a href="{{ $settings->company_url }}" 
                   class="hidden md:inline mr-10 text-primary-350 hover:text-primary-300 transition-colors">
                    {{ parse_url($settings->company_url, PHP_URL_HOST) ?? $settings->company_name }}
                </a>
            @endif

            {{-- Phone Numbers --}}
            @if($settings->company_phone_number_first)
                <a href="tel:{{ preg_replace('/\D/', '', $settings->company_phone_number_first) }}" 
                   class="flex text-xs items-center gap-1 text-primary-350 hover:text-primary-300 transition-colors">
                    <i class="fa-solid fa-phone text-xs"></i>
                    {{ $settings->company_phone_number_first }}
                </a>
            @endif

            @if($settings->company_phone_number_second)
                <span class="text-gray-600">|</span>
                <a href="tel:{{ preg_replace('/\D/', '', $settings->company_phone_number_second) }}" 
                   class="flex text-xs items-center gap-1 text-primary-350 hover:text-primary-300 transition-colors">
                    <i class="fa-solid fa-phone text-xs"></i>
                    {{ $settings->company_phone_number_second }}
                </a>
            @endif
        </div>

        {{-- Right: social + language --}}
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center sm:justify-end gap-3 sm:gap-4 w-full sm:w-auto">

                {{-- Social Icons --}}
                <div class="hidden sm:flex items-center gap-1.5 sm:gap-2 mr-4">
                    @if($settings->facebook_link)
                        <a href="{{ $settings->facebook_link }}" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-black rounded-full border border-gray-500 hover:bg-gray-100 transition-colors">
                            <i class="fa-brands fa-facebook-f text-xs sm:text-sm"></i>
                        </a>
                    @endif
                    @if($settings->tiktok_link)
                        <a href="{{ $settings->tiktok_link }}" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-black rounded-full border border-gray-300 hover:bg-gray-100 transition-colors">
                            <i class="fa-brands fa-tiktok text-xs sm:text-sm"></i>
                        </a>
                    @endif
                    @if($settings->instagram_link)
                        <a href="{{ $settings->instagram_link }}" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-black rounded-full border border-gray-500 hover:bg-gray-100 transition-colors">
                            <i class="fa-brands fa-instagram text-xs sm:text-sm"></i>
                        </a>
                    @endif
                    @if($settings->telegram_link)
                        <a href="{{ $settings->telegram_link }}" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-black rounded-full border border-gray-500 hover:bg-gray-100 transition-colors">
                            <i class="fa-brands fa-telegram text-xs sm:text-sm"></i>
                        </a>
                    @endif
                </div>

                {{-- Language Switcher --}}
                <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm">
                    <a href="{{ route('locale.switch', ['locale' => 'kh']) }}"
                    class="transition-colors {{ app()->getLocale() === 'kh' ? 'text-primary-400 font-semibold' : 'text-gray-600 hover:text-primary-400' }}">
                        {{ __('messages.khmer') }}
                    </a>
                    <span class="text-gray-600">\</span>
                    <a href="{{ route('locale.switch', ['locale' => 'en']) }}"
                    class="transition-colors {{ app()->getLocale() === 'en' ? 'text-primary-400 font-semibold' : 'text-gray-600 hover:text-primary-400' }}">
                        {{ __('messages.english') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- resources/views/components/header.blade.php --}}

<div class="bg-gray-800 text-gray-300 text-xs py-1.5 px-4">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-2">

        {{-- Left: Website + Phone Numbers --}}
        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-3 gap-y-1 text-sm w-full sm:w-auto">

            {{-- Website: hidden on mobile --}}
            <a href="https://www.cpksolution.com" class="hidden md:inline mr-10 text-primary-350 hover:text-primary-300 transition-colors">
                www.cpksolution.com
            </a> 

            {{-- Phone Numbers: always visible --}}
            <a href="tel:012345678" class="flex items-center gap-1 text-primary-350  hover:text-primary-300 transition-colors">
                <i class="fa-solid fa-phone text-xs"></i>
                012 345 678
            </a>

            <span class="text-gray-600">|</span>

            <a href="tel:010234567" class="flex items-center gap-1 text-primary-350  hover:text-primary-300 transition-colors">
                <i class="fa-solid fa-phone text-xs"></i>
                010 234 567
            </a>
        </div>

        {{-- Right: Social Icons + Language --}}
        <div class="flex items-center justify-center sm:justify-end gap-3 sm:gap-4 w-full sm:w-auto">

            {{-- Social Icons: always visible --}}
            <div class="flex items-center gap-1.5 sm:gap-2 mr-4">
                <a href="https://www.facebook.com/yourpage" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-blue-600 rounded-full border border-gray-500 hover:bg-gray-100 transition-colors">
                    <i class="fa-brands fa-facebook text-xs sm:text-sm"></i>
                </a>
                <a href="https://www.tiktok.com/@yourusername" class=" sm:w-7 sm:h-7 flex items-center justify-center bg-white text-black rounded-full border border-gray-300 hover:bg-gray-100 transition-colors">
                    <i class="fa-brands fa-tiktok text-xs sm:text-sm"></i>
                </a>
                <a href="https://www.instagram.com/yourusername" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-pink-500 rounded-full border border-gray-500 hover:bg-gray-100 transition-colors">
                    <i class="fa-brands fa-instagram text-xs sm:text-sm"></i>
                </a>
                <a href="https://t.me/yourchannel" class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center bg-white text-blue-400 rounded-full border border-gray-500 hover:bg-gray-100 transition-colors">
                    <i class="fa-brands fa-telegram text-xs sm:text-sm"></i>
                </a>
            </div>


            {{-- Language Switcher: always visible --}}
            <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm">
                <a href="?lang=km"
                class="hover:text-primary-400 transition-colors {{ app()->getLocale() === 'km' ? 'text-primary-400 font-semibold' : '' }}">
                    Khmer
                </a>
                <span class="text-gray-600">\</span>
                <a href="?lang=en"
                   class="hover:text-primary-400 transition-colors {{ app()->getLocale() === 'en' ? 'text-primary-0 font-semibold' : '' }}">
                    English
                </a>
            </div>

        </div>

    </div>
</div>
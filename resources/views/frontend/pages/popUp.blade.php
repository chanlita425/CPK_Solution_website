{{-- Image Popup --}}
<div id="welcome-overlay"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
    style="display:none;">

    <div class="relative bg-white rounded-2xl overflow-hidden shadow-xl w-full max-w-sm">

        {{-- Close X button --}}
        <button onclick="closePopup()"
            class="absolute top-3 right-3 z-10 w-7 h-7 rounded-full bg-black/40 text-white flex items-center justify-center text-base leading-none hover:bg-black/60 transition">
            &times;
        </button>

        {{-- Image --}}
        <img src="{{ asset('images/popup-banner.jpg') }}"
            alt="Special offer"
            class="w-full h-48 object-cover block">

        {{-- Body --}}
        <div class="px-6 py-5 text-center">

            {{-- Tag --}}
            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full mb-3"
                style="background:#C9A84C22; color:#854F0B;">
                Limited offer
            </span>

            <h2 class="text-lg font-semibold text-gray-900 mb-1">Get 20% off today only</h2>
            <p class="text-sm text-gray-500 mb-5 leading-relaxed">
                Use code <span class="font-bold text-gray-700">WELCOME20</span> at checkout.
                Valid for new customers only.
            </p>

            {{-- CTA --}}
            <a href="{{ url('/shop') }}"
                class="block w-full py-2.5 rounded-full text-sm font-semibold text-black text-center mb-2"
                style="background:#C9A84C;">
                Shop now
            </a>

            <button onclick="closePopup()"
                class="text-xs text-gray-400 underline hover:text-gray-600">
                No thanks, I'll pay full price
            </button>
        </div>
    </div>
</div>

<script>
    function showPopup() {
        document.getElementById('welcome-overlay').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('welcome-overlay').style.display = 'none';
        localStorage.setItem('popup_seen', '1');
    }

    // Show after 2 seconds if not seen before
    if (!localStorage.getItem('popup_seen')) {
        setTimeout(showPopup, 2000);
    }
</script>
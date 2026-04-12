{{-- Image Popup --}}
<div id="welcome-overlay"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

    <div class="relative bg-white rounded-2xl overflow-hidden shadow-xl w-full max-w-sm">

        {{-- Close button --}}
        <button onclick="closePopup()"
            class="absolute top-3 right-3 z-10 w-7 h-7 rounded-full bg-black/40 text-white flex items-center justify-center text-base hover:bg-black/60 transition">
            &times;
        </button>

        {{-- Dynamic Image --}}
        <img id="popup-image"
            src="{{ asset('storage/' . ($settings->popup_banner_image ?? 'images/popup-banner.jpg')) }}"
            alt="Special offer"
            onload="adjustPopup(this)"
            class="w-full h-auto block object-contain ">
    </div>
</div>

<script>
    (function () {
        const overlay = document.getElementById('welcome-overlay');
        const imgSrc  = document.getElementById('popup-image').src;

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : null;
        }

        // Show only if image has changed or never seen before
        if (getCookie('popup_image') === imgSrc) {
            overlay.classList.add('hidden');
        }
    })();

    function closePopup() {
        const overlay = document.getElementById('welcome-overlay');
        const imgSrc  = document.getElementById('popup-image').src;

        overlay.classList.add('hidden');

        // Store in cookie for 3 hours
        const expires = new Date(Date.now() + 3 * 60 * 60 * 1000).toUTCString();
        document.cookie = 'popup_image=' + encodeURIComponent(imgSrc) + '; expires=' + expires + '; path=/';
    }

    function adjustPopup(img) {
        const container = img.closest('.relative');
        const isLandscape = img.naturalWidth > img.naturalHeight;

        if (isLandscape) {
            img.classList.remove('h-auto');
            img.classList.add('h-[350px]', 'object-cover');
            container.classList.remove('max-w-sm');
            container.classList.add('max-w-2xl');
        } else {
            img.classList.add('h-auto');
            img.classList.remove('h-[350px]', 'object-cover');
            container.classList.remove('max-w-2xl');
            container.classList.add('max-w-sm');
        }
    }

</script>
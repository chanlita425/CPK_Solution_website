    <div class="w-full lg:w-1/2 flex flex-col gap-3 sm:gap-4">

        {{-- Name --}}
        <h1 class="text-base sm:text-lg lg:text-xl font-bold text-gray-800 leading-snug">
            {{ $product->name }}
        </h1>

        {{-- Meta --}}
        <div class="flex flex-col gap-1 text-xs sm:text-sm text-gray-500">

            <p>
                Brand:
                <span class="text-gray-700 font-medium">
                    {{ $product->brand->name ?? 'N/A' }}
                </span>
            </p>

            <p>
                SKU:
                <span class="text-gray-700 font-medium">
                    {{ $product->SKU ?? 'N/A' }}
                </span>
            </p>

        </div>

        {{-- Price --}}
        <p class="text-lg sm:text-xl font-bold" style="color:#C9A84C;">
            ${{ number_format($product->price, 2) }}
        </p>

        {{-- Specifications --}}
        <div>
            <p class="text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
                Specification:
            </p>

            @php
                // STEP 1: take raw text
                $raw = $product->specification ?? '';

                // STEP 2: split by NEW LINE (Enter)
                $specs = preg_split("/\r\n|\n|\r/", trim($raw));

                // STEP 3: remove empty lines
                $specs = array_filter($specs);
            @endphp

            @if(count($specs))
                <ul class="space-y-1">
                    @foreach($specs as $spec)
                        <li class="text-xs sm:text-sm text-black flex gap-1">
                            <span class="text-gray-600">.</span>
                            <span>{{ trim($spec) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-xs text-gray-400">No specification available</p>
            @endif
        </div>
        
        {{-- Quantity --}}
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-2 sm:gap-3 text-md sm:text-[20px] text-gray-700">
            <span class="font-medium text-center sm:text-left">
                Quantity
            </span>

            <div class="flex items-center gap-1 sm:gap-2">
                <button onclick="changeQty(-1)"
                    class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 flex items-center justify-center hover:bg-gray-100 transition">
                    -
                </button>

                <span id="qty-display"
                    class="w-8 sm:w-10 md:w-12 text-center font-semibold text-sm sm:text-base md:text-lg">
                    1
                </span>

                <button onclick="changeQty(1)"
                    class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 flex items-center justify-center hover:bg-gray-100 transition">
                    +
                </button>
            </div>
        </div>

    {{-- Add to Cart --}}
    <div class="pt-2">
        <button id="add-to-cart-btn"
            onclick="addToCart({{ $product->id }})"
            class="w-full sm:w-auto px-4 py-2 rounded-full text-sm sm:text-base font-semibold text-black hover:brightness-95 transition-all shadow-md active:scale-95"
            style="background:#C9A84C;">
            Add to Cart
        </button>
    </div>

    {{-- Toast --}}
    <div id="cart-toast"
        class="fixed bottom-6 right-6 z-50 hidden flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg text-white text-sm font-medium"
        style="background:#C9A84C;">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span id="cart-toast-msg">Added to cart!</span>
        <a href="{{ url('/order') }}" class="ml-2 underline font-bold hover:opacity-80">View Cart</a>
    </div>

{{-- Scripts --}}
<script>

    
    let qty = 1;

    function changeQty(delta) {
        qty = Math.max(1, qty + delta);
        document.getElementById('qty-display').textContent = qty;
    }

    function addToCart(productId) {
        const btn = document.getElementById('add-to-cart-btn');
        btn.disabled    = true;
        btn.textContent = 'Adding…';

        fetch("{{ url('/cart/add') }}/" + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept':       'application/json',
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                showToast('Added to cart!', true);

                // update navbar badge if exists
                const badge = document.getElementById('cart-count');
                if (badge) badge.textContent = res.cart_count;
            } else {
                showToast(res.message || 'Failed to add to cart.', false);
            }
        })
        .catch(() => showToast('Something went wrong.', false))
        .finally(() => {
            btn.disabled    = false;
            btn.textContent = 'Add to Cart';
        });
    }

    function showToast(msg, success) {
        const toast = document.getElementById('cart-toast');
        document.getElementById('cart-toast-msg').textContent = msg;
        toast.style.background = success ? '#C9A84C' : '#ef4444';
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }

    function addToCart(productId) {
    const btn = document.getElementById('add-to-cart-btn');
    btn.disabled    = true;
    btn.textContent = 'Adding…';

    fetch("{{ url('/cart/add') }}/" + productId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept':       'application/json',
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            window.location.href = "{{ route('cart.index') }}"; // ← redirect to cart page
        } else {
            showToast(res.message || 'Failed to add to cart.', false);
            btn.disabled    = false;
            btn.textContent = 'Add to Cart';
        }
    })
    .catch(() => {
        showToast('Something went wrong.', false);
        btn.disabled    = false;
        btn.textContent = 'Add to Cart';
    });
}
</script>
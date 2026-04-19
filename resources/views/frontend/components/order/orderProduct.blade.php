    {{-- ── LEFT: Cart items (wrapped as ONE card) ── --}}
    <div class="w-full md:w-[55%]">
        <div class="rounded-2xl flex flex-col gap-3 sm:gap-4">

            @foreach($cartItems as $item)
                <div class="flex flex-col xs:flex-col sm:flex-row items-center sm:items-start gap-3 sm:gap-5 border border-gray-100 shadow-sm
                            px-4 py-4 sm:py-6 rounded-[40px] bg-gray-100">

                    {{-- Product image --}}
                    <a href="{{ url('/product/' . $item['slug']) }}"
                        class="flex items-center justify-center shrink-0
                            w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-36 lg:h-36">

                        @php
                            $product = \App\Models\Product::find($item['id']);
                        @endphp

                        @if($product && $product->main_image_url)
                            <img src="{{ asset($product->main_image_url) }}"
                                alt="{{ $item['name'] }}"
                                class="w-full h-full object-contain rounded-lg">
                        @else
                            <div class="w-full h-full bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-300 text-2xl"></i>
                            </div>
                        @endif
                    </a>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0 flex flex-col gap-1 sm:gap-2 w-full
                                xs:items-center sm:items-start md:items-start
                                text-center sm:text-left md:text-left">

                        {{-- Product name --}}
                        <p class="text-sm md:text-sm lg:text-lg font-semibold text-gray-700   overflow-hidden   text-center sm:text-left md:text-left">
                            {{ $item['name'] }}
                        </p>

                        {{-- Price --}}
                        <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900">
                            ${{ number_format($item['price'], 2) }}
                        </p>

                        {{-- Qty selector --}}
                        <div class="flex items-center border border-gray-200 rounded-full w-fit overflow-hidden mt-2 sm:mt-1">
                            <button onclick="changeCartQty({{ $item['id'] }}, -1)"
                                    class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 flex items-center justify-center text-gray-500 hover:bg-gray-100">
                                -
                            </button>

                            <span id="qty-{{ $item['id'] }}"
                                class="w-10 sm:w-12 md:w-14 text-center text-sm sm:text-base md:text-lg font-semibold">
                                {{ $item['qty'] }}
                            </span>

                            <button onclick="changeCartQty({{ $item['id'] }}, 1)"
                                    class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 flex items-center justify-center text-gray-500 hover:bg-gray-100">
                                +
                            </button>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    </div>

    {{-- RIGHT: Payment checkout --}}
    <div class="w-full md:w-[45%]">
        <div class="bg-gray-100 rounded-[30px] border border-gray-100 shadow-sm
                    p-5 sm:p-8 lg:p-10
                    flex flex-col gap-5
                    md:sticky md:top-10 lg:top-24">

            {{-- Coupon --}}
            <div class="flex flex-col sm:flex-row gap-2 w-full">
                <input type="text"
                    id="coupon-input"
                    placeholder="{{ __('messages.coupon_code') }}"
                    class="flex-1 bg-[#FAF6EE] rounded-full px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-300 w-full sm:w-auto"
                >
                <button onclick="applyCoupon()"
                        id="coupon-btn"
                        class="px-5 py-2.5 rounded-full text-sm font-semibold w-full sm:w-auto"
                        style="background:#F5E6C8;">
                    {{ __('messages.apply') }}
                </button>
            </div>

            {{-- Coupon message --}}
            <div id="coupon-message" class="text-sm hidden px-1"></div>

            <hr>

            {{-- Prices --}}
            <div class="flex flex-col gap-2 text-sm sm:text-base text-gray-600">
                <div class="flex justify-between">
                    <span>{{ __('messages.subtotal') }}</span>
                    <span id="display-subtotal" class="font-medium text-gray-800">${{ number_format($subtotal, 2) }}</span>
                </div>

                {{-- Discount row (hidden until coupon applied) --}}
                <div id="discount-row" class="flex justify-between text-green-600 hidden">
                    <span id="discount-label">{{ __('messages.discount') }}</span>
                    <span id="display-discount" class="font-medium">-$0.00</span>
                </div>

                <div class="flex justify-between">
                    <span>{{ __('messages.shipping') }}</span>
                    <span id="display-shipping" class="font-medium text-gray-800">${{ number_format($shipping, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>{{ __('messages.tax') }}</span>
                    <span id="display-tax" class="font-medium text-gray-800">${{ number_format($tax, 2) }}</span>
                </div>
            </div>

            {{-- Total --}}
            <div class="flex sm:flex-row justify-between items-start sm:items-center pt-7 w-full">
                <span class="text-xl sm:text-3xl font-black">{{ __('messages.total') }}</span>
                <span id="display-total" class="text-xl sm:text-3xl font-black text-yellow-600 sm:mt-0">
                    ${{ number_format($total, 2) }}
                </span>
            </div>

            <div class="flex flex-wrap gap-2 pt-3 mt-2 w-full items-center">
                <button onclick="confirmClearCart()"
                        class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-[#D7B259] text-sm hover:bg-gray-50 transition-colors">
                    {{ __('messages.clear_cart') }}
                </button>

                <a href="{{ url('/products') }}"
                    class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-[#D7B259] text-sm hover:bg-gray-50 transition-colors">
                    {{ __('messages.shopping') }}
                </a>

                <form action="{{ route('checkout.process') }}" method="POST" class="order-last sm:order-last">
                    @csrf
                    <button type="submit"
                            class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-sm sm:text-base font-bold text-white shadow-md"
                            style="background:#C9A84C;">
                        {{ __('messages.check_out') }}
                    </button>
                </form>
            </div>

        </div>
    </div>

@push('scripts')
<script>
    function changeCartQty(id, delta) {
        const el = document.getElementById('qty-' + id);
        let qty = parseInt(el.innerText);
        qty = Math.max(1, qty + delta);
        el.innerText = qty;

        fetch("{{ url('/cart/update') }}/" + id, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                updatePrices(res);
            }
        });
    }

    function removeItem(id) {
        fetch("{{ url('/cart/remove') }}/" + id, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        })
        .then(r => r.json())
        .then(res => { if (res.success) location.reload(); });
    }

    function confirmClearCart() {
        fetch("{{ route('cart.clear') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        })
        .then(r => r.json())
        .then(res => { if (res.success) location.reload(); });
    }

    // ── Coupon ──────────────────────────────────────────────

    function applyCoupon() {
        const code  = document.getElementById('coupon-input').value.trim();
        const btn   = document.getElementById('coupon-btn');

        if (!code) {
            showCouponMsg('{{ __("messages.please_enter_coupon") }}', false);
            return;
        }

        btn.disabled    = true;
        btn.textContent = '{{ __("messages.applying") }}…';

        fetch("{{ route('coupon.apply') }}", {
            method: 'POST',
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  '{{ csrf_token() }}',
            },
            body: JSON.stringify({ code: code })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                updatePrices(res);

                document.getElementById('discount-label').innerHTML =
                    '{{ __("messages.discount") }} (' + res.coupon_code + ')&nbsp;' +
                    '<button onclick="removeCoupon()" class="ml-1 text-red-400 hover:text-red-600 text-xs underline">{{ __("messages.remove") }}</button>';
                document.getElementById('display-discount').textContent = '-$' + res.discount;
                document.getElementById('discount-row').classList.remove('hidden');

                document.getElementById('coupon-input').disabled = true;
                btn.style.display = 'none';

                showCouponMsg(res.message, true);
            } else {
                showCouponMsg(res.message, false);
                btn.disabled    = false;
                btn.textContent = '{{ __("messages.apply") }}';
            }
        })
        .catch(err => {
            console.error(err);
            showCouponMsg('{{ __("messages.something_wrong") }}', false);
            btn.disabled    = false;
            btn.textContent = '{{ __("messages.apply") }}';
        });
    }

    function removeCoupon() {
        fetch("{{ route('coupon.remove') }}", {
            method: 'DELETE',
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  '{{ csrf_token() }}',
            }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                updatePrices(res);

                document.getElementById('discount-row').classList.add('hidden');
                document.getElementById('coupon-input').value    = '';
                document.getElementById('coupon-input').disabled = false;

                const btn = document.getElementById('coupon-btn');
                btn.style.display = '';
                btn.disabled      = false;
                btn.textContent   = '{{ __("messages.apply") }}';

                showCouponMsg('{{ __("messages.coupon_removed") }}', true);
            }
        })
        .catch(() => showCouponMsg('{{ __("messages.failed_to_remove") }}', false));
    }

    function updatePrices(res) {
        document.getElementById('display-subtotal').textContent = '$' + res.subtotal;
        document.getElementById('display-shipping').textContent = '$' + res.shipping;
        document.getElementById('display-tax').textContent      = '$' + res.tax;
        document.getElementById('display-total').textContent    = '$' + res.total;
    }

    function showCouponMsg(msg, success) {
        const el = document.getElementById('coupon-message');
        el.textContent = msg;
        el.className   = 'text-sm px-1 ' + (success ? 'text-green-600' : 'text-red-500');
        el.classList.remove('hidden');
    }

</script>
@endpush

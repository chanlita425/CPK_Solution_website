{{-- Order card --}}
<section id="order_card" style="scroll-margin-top: 80px;" class="px-6 sm:px-8 lg:px-12 mt-6 sm:mt-8 py-5">
    <div class="flex flex-col md:flex-row gap-10 lg:gap-8 items-start">
        @include('frontend.components.order.orderProduct')
    </div>
</section>

{{-- Similar Items --}}
<section id="product-grid" class="mt-6 lg:mt-16 sm:px-12 px-8 lg:px-4 sm:px-4">
    <h2 class="text-center text-base sm:text-lg font-semibold mb-6 sm:mb-8" style="color:#C9A84C;">
        Similar Items
    </h2>
    <div id="add-cards-container">
        @include('frontend.components.cards.cardResponsive')
    </div>
</section>

<script>
(function () {
    window.changeCartQty = function (id, delta) {
        const el  = document.getElementById('qty-' + id);
        let qty   = parseInt(el.innerText);
        qty       = Math.max(1, qty + delta);
        el.innerText = qty;

        fetch("{{ url('/cart/update') }}/" + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(r => r.json())
        .then(res => { if (res.success) updatePrices(res); });
    };

    window.removeItem = function (id) {
        fetch("{{ url('/cart/remove') }}/" + id, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => { if (res.success) window.navigateToCart && window.navigateToCart(); });
    };

    window.confirmClearCart = function () {
        fetch("{{ route('cart.clear') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => { if (res.success) window.navigateToCart && window.navigateToCart(); });
    };

    window.applyCoupon = function () {
        const code = document.getElementById('coupon-input').value.trim();
        const btn  = document.getElementById('coupon-btn');

        if (!code) { showCouponMsg('Please enter a coupon code.', false); return; }

        btn.disabled    = true;
        btn.textContent = 'Applying…';

        fetch("{{ route('coupon.apply') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ code })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                updatePrices(res);
                document.getElementById('discount-label').innerHTML =
                    'Discount (' + res.coupon_code + ')&nbsp;' +
                    '<button onclick="removeCoupon()" class="ml-1 text-red-400 hover:text-red-600 text-xs underline">Remove</button>';
                document.getElementById('display-discount').textContent = '-$' + res.discount;
                document.getElementById('discount-row').classList.remove('hidden');
                document.getElementById('coupon-input').disabled = true;
                btn.style.display = 'none';
                showCouponMsg(res.message, true);
            } else {
                showCouponMsg(res.message, false);
                btn.disabled    = false;
                btn.textContent = 'Apply';
            }
        })
        .catch(() => {
            showCouponMsg('Something went wrong.', false);
            btn.disabled    = false;
            btn.textContent = 'Apply';
        });
    };

    window.removeCoupon = function () {
        fetch("{{ route('coupon.remove') }}", {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                btn.textContent   = 'Apply';
                showCouponMsg('Coupon removed.', true);
            }
        })
        .catch(() => showCouponMsg('Failed to remove coupon.', false));
    };

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
})();
</script>

    
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

                        <button onclick="removeItem({{ $item['id'] }})"
                                class="text-red-500 text-sm mt-2 hover:underline flex items-center px-3">
                            Remove
                        </button>
                    </div>
                
                </div>
            @endforeach
        </div>
    </div>

    {{-- RIGHT: Payment checkout  --}}
    <div class="w-full md:w-[45%]">
        <div class="bg-gray-100 rounded-[30px] border border-gray-100 shadow-sm 
                    p-5 sm:p-8 lg:p-10
                    flex flex-col gap-5 
                    md:sticky md:top-10 lg:top-24">

            {{-- Coupon --}}
            <div class="flex flex-col sm:flex-row gap-2 w-full">
                <input type="text"
                    placeholder="Coupon Code"
                    class="flex-1 bg-[#FAF6EE] rounded-full px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-300 w-full sm:w-auto"
                >

                <button class="px-5 py-2.5 rounded-full text-sm font-semibold w-full sm:w-auto"
                        style="background:#F5E6C8;">
                    Apply
                </button>
            </div>

            <hr>

            {{-- Prices --}}
            <div class="flex flex-col gap-2 text-sm sm:text-base text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-medium text-gray-800">${{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span class="font-medium text-gray-800">${{ number_format($shipping, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Tax</span>
                    <span class="font-medium text-gray-800">${{ number_format($tax, 2) }}</span>
                </div>
            </div>

            {{-- Total --}}
            <div class="flex sm:flex-row justify-between items-start sm:items-center pt-7 w-full">
                <span class="text-xl sm:text-3xl font-black">Total</span>
                <span class="text-xl sm:text-3xl font-black text-yellow-600  sm:mt-0  ">
                    ${{ number_format($total, 2) }}
                </span>
            </div>
            
            <div class="flex flex-wrap gap-2 pt-3 mt-2 w-full items-center">
                <button onclick="clearCart()"
                        class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-[#D7B259] text-sm hover:bg-gray-50 transition-colors">
                    Clear Cart
                </button>

                <a href="{{ url('/products') }}"
                class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-[#D7B259] text-sm hover:bg-gray-50 transition-colors">
                    Shopping
                </a>

                <a href="{{ url('/checkout') }}"
                class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-[#D7B259] text-sm sm:text-base font-bold text-white shadow-md order-last sm:order-last"
                style="background:#C9A84C;">
                    Check Out
                </a>
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
                if (res.success) location.reload();
            });
        }

        function removeItem(id) {
            fetch("{{ url('/cart/remove') }}/" + id, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) location.reload();
            });
        }

        function clearCart() {
            if (!confirm('Clear cart?')) return;

            fetch("{{ route('cart.clear') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) location.reload();
            });
        }

        function addToCart(id) {
            fetch("{{ url('/cart/add') }}/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert("Added to cart!");
                }
            });
        }

    </script>
    @endpush
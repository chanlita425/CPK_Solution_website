@extends('frontend.layouts.app')

@section('title', 'CPK Solution - Home')

@section('content') 

{{-- Order card --}}
<section id="order_card" class="px-6 sm:px-8 lg:px-12 mt-6 sm:mt-8 py-5">
    <div class="flex flex-col md:flex-row gap-10 lg:gap-8 items-start">
        @include('frontend.components.order.orderProduct')
    </div>
</section>

{{-- CARD PRODUCT --}}
<section id="product-grid" class="mt-6 lg:mt-16 sm:px-12 px-8 lg:px-4 sm:px-4">
    
    <h2 class="text-center text-base sm:text-lg font-semibold mb-6 sm:mb-8" style="color:#C9A84C;">
        Similar Items
    </h2>

    <div id="add-cards-container">
        @include('frontend.components.cards.cardResponsive')
    </div>

</section>
@endsection

{{-- @push('scripts')
<script>
    const cartQtys = {
        @foreach($cartItems as $item)
            {{ $item['id'] }}: {{ $item['qty'] }},
        @endforeach
    };

    function changeCartQty(id, delta) {
        let newQty = Math.max(1, (cartQtys[id] || 1) + delta);

        fetch(`/cart/update/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ qty: newQty })
        })
        .then(() => location.reload());
    }

    function clearCart() {
        if (!confirm("Are you sure you want to clear cart?")) return;

        fetch("{{ route('cart.clear') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload(); // refresh UI
            }
        })
        .catch(err => console.error(err));
    }

    function addToCart(productId) {
        console.log('Add to cart:', productId);
    }
</script>
@endpush --}}
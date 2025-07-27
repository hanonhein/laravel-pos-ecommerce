{{-- resources/views/checkout/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-light">Checkout</h1>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-5">
            {{-- Billing & Shipping Information Column --}}
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Shipping Address</h4>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="shipping_address" class="form-label">Full Address</label>
                        <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required></textarea>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Billing Address</h4>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="same-address" checked>
                    <label class="form-check-label" for="same-address">Billing address is the same as my shipping address</label>
                </div>
                <input type="hidden" name="billing_address" id="billing_address_input">


                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>
                <p class="text-muted">
                    For this project, we will simulate a successful payment.
                    No real payment gateway is connected.
                </p>

            </div>

            {{-- Order Summary Column --}}
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill">{{ $cart->cartItems->sum('quantity') }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @php
                        // This is the corrected total calculation
                        $total = $cart->cartItems->sum(function($item) {
                            return $item->price * $item->quantity;
                        });
                    @endphp
                    @foreach ($cart->cartItems as $item)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $item->product->name }}</h6>
                                <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                            </div>
                            {{-- This now uses the correct item price for the subtotal --}}
                            <span class="text-muted">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach

                    {{-- This is the re-added promo code example --}}
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">−$0.00</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </li>
                </ul>

                <button class="w-100 btn btn-primary btn-lg" type="submit">Place Order</button>
            </div>
        </div>
    </form>
</div>

{{-- JavaScript for the address checkbox --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingAddress = document.getElementById('shipping_address');
        const billingAddressInput = document.getElementById('billing_address_input');
        const sameAddressCheckbox = document.getElementById('same-address');

        function updateBillingAddress() {
            if (sameAddressCheckbox.checked) {
                billingAddressInput.value = shippingAddress.value;
            }
        }

        // Initial update
        updateBillingAddress();

        shippingAddress.addEventListener('keyup', updateBillingAddress);
        sameAddressCheckbox.addEventListener('change', function() {
            if (this.checked) {
                updateBillingAddress();
            } else {
                billingAddressInput.value = ''; // Clear if unchecked
            }
        });
    });
</script>
@endsection

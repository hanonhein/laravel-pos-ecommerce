{{-- resources/views/cart/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-light">Your Shopping Cart</h1>
        </div>
    </div>

    {{-- Check if the cart exists and has items --}}
    @if ($cart && $cart->cartItems->count() > 0)
        <div class="row">
            {{-- Cart Items Column --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @foreach ($cart->cartItems as $item)
                            <div class="row align-items-center {{ !$loop->last ? 'mb-4 border-bottom pb-4' : '' }}">
                                {{-- Product Image --}}
                                <div class="col-md-2">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->product->name }}" class="img-fluid rounded">
                                </div>
                                {{-- Product Details --}}
                                <div class="col-md-4">
                                    <h5 class="mb-0">{{ $item->product->name }}</h5>
                                    {{-- Use the stored item price --}}
                                    <small class="text-muted">Price: ${{ number_format($item->price, 2) }}</small>
                                </div>
                                {{-- Quantity Update Form --}}
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item->quantity }}" min="1">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">Update</button>
                                    </form>
                                </div>
                                {{-- Price & Remove Button --}}
                                <div class="col-md-3 text-end">
                                    {{-- Calculate subtotal with the stored item price --}}
                                    <p class="h5 mb-2">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Order Summary Column --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        @php
                            // Calculate total using the stored price on each item
                            $total = $cart->cartItems->sum(function($item) {
                                return $item->price * $item->quantity;
                            });
                        @endphp
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>
                            <span class="text-success">FREE</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold h5">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-grid mt-4">
                            <a href="{{ route('checkout.create') }}" class="btn btn-primary btn-lg">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart Message --}}
        <div class="row">
            <div class="col-12 text-center">
                <div class="card border-0 shadow-sm py-5">
                    <div class="card-body">
                        <h3 class="card-title">Your cart is empty.</h3>
                        <p class="card-text text-muted">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

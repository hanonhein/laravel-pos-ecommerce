{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h1 class="text-success">Thank You!</h1>
                    <p class="lead">Your order has been placed successfully.</p>
                    <hr>
                    <p>Your Order Number is: <strong>{{ $order->order_number }}</strong></p>
                    <p>We have sent an email confirmation to you with the order details.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

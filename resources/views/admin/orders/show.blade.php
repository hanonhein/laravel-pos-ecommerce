{{-- resources/views/admin/orders/show.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details: {{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        {{-- Order & Customer Details --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Order Summary</div>
                <div class="card-body">
                    <p><strong>Order #:</strong> {{ $order->order_number }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                    <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($order->status) }}</span></p>

                    {{-- This is the new form to update the status --}}
                    <hr>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="input-group">
                            <select name="status" class="form-select">
                                <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                                <option value="shipped" @if($order->status == 'shipped') selected @endif>Shipped</option>
                                <option value="delivered" @if($order->status == 'delivered') selected @endif>Delivered</option>
                                <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Customer Details</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Shipping Address:</strong><br>{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        {{-- Items in Order --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Items Ordered</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

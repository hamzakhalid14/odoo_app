@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Order Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order #{{ $order->id }}</h5>
            <p class="card-text"><strong>Customer:</strong> {{ $order->customer->name }}</p>
            <p class="card-text"><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p class="card-text"><strong>Created at:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
            <p class="card-text"><strong>Updated at:</strong> {{ $order->updated_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    <h2>Order Items</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
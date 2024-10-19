@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Order</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select class="form-control" id="customer_id" name="customer_id" required>
                <option value="">Select a customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div id="order-items">
            @foreach ($order->orderItems as $item)
                <div class="form-group order-item">
                    <label>Product</label>
                    <select class="form-control product-select" name="products[]" required>
                        <option value="">Select a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - ${{ number_format($product->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    <label>Quantity</label>
                    <input type="number" class="form-control quantity-input" name="quantities[]" value="{{ $item->quantity }}" min="1" required>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-item">Add Item</button>
        
        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" step="0.01" readonly>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderItems = document.getElementById('order-items');
        const addItemButton = document.getElementById('add-item');
        const totalAmountInput = document.getElementById('total_amount');

        addItemButton.addEventListener('click', function() {
            const newItem = orderItems.children[0].cloneNode(true);
            newItem.querySelectorAll('input, select').forEach(input => input.value = '');
            orderItems.appendChild(newItem);
        });

        orderItems.addEventListener('change', calculateTotal);
        orderItems.addEventListener('input', calculateTotal);

        function calculateTotal() {
            let total = 0;
            const items = orderItems.children;
            for (let item of items) {
                const productSelect = item.querySelector('.product-select');
                const quantityInput = item.querySelector('.quantity-input');
                const price = productSelect.options[productSelect.selectedIndex].dataset.price;
                const quantity = quantityInput.value;
                total += price * quantity;
            }
            totalAmountInput.value = total.toFixed(2);
        }

        calculateTotal();
    });
</script>
@endpush
@endsection
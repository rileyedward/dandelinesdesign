@extends('mail.layouts.base')

@section('title', 'Order Confirmation - ' . $order->order_number)

@section('content')
<h2>Thank you for your order, {{ $customerName }}!</h2>

<p>We've received your order and it's being processed. Here are the details:</p>

<div class="order-summary">
    <h3>Order #{{ $order->order_number }}</h3>
    
    <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
    <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>

    @if($order->line_items && count($order->line_items) > 0)
        <h3>Items Ordered:</h3>
        @foreach($order->line_items as $item)
            <div class="order-item">
                <strong>{{ $item->product_name }}</strong><br>
                Quantity: {{ $item->quantity }}<br>
                Price: ${{ number_format($item->unit_price, 2) }}
            </div>
        @endforeach
    @endif

    <div class="order-total">
        <strong>Total: ${{ $orderTotal }}</strong>
    </div>
</div>

@if($order->shipping_address_line_1)
<h3>Shipping Address:</h3>
<p>
    {{ $order->shipping_address_line_1 }}<br>
    @if($order->shipping_address_line_2)
        {{ $order->shipping_address_line_2 }}<br>
    @endif
    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
    {{ $order->shipping_country }}
</p>
@endif

<p>We'll send you another email when your order ships. If you have any questions, please don't hesitate to contact us.</p>

<a href="{{ config('app.url') }}/orders/{{ $order->id }}" class="button">View Order Details</a>
@endsection
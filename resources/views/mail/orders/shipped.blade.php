@extends('mail.layouts.base')

@section('title', 'Order Shipped - ' . $order->order_number)

@section('content')
<h2>Great news, {{ $customerName }}! Your order has shipped!</h2>

<p>We're excited to let you know that your order is on its way to you.</p>

<div class="order-summary">
    <h3>Order #{{ $order->order_number }}</h3>
    
    <p><strong>Status:</strong> <span style="color: #059669; font-weight: 600;">Shipped</span></p>
    <p><strong>Shipped Date:</strong> {{ $order->shipped_at ? $order->shipped_at->format('F j, Y \a\t g:i A') : 'Just now' }}</p>
    
    @if($order->tracking_number)
    <div class="tracking-info" style="background: #f0f9ff; border: 2px solid #0ea5e9; border-radius: 8px; padding: 20px; margin: 20px 0;">
        <h3 style="color: #0369a1; margin-top: 0;">Tracking Information</h3>
        <p><strong>Tracking Number:</strong> <span style="font-family: monospace; font-size: 16px; color: #0369a1;">{{ $order->tracking_number }}</span></p>
        <p style="margin-bottom: 0;">You can track your package using the tracking number above with your shipping carrier.</p>
    </div>
    @endif
    
    @if($order->shipping_method)
    <p><strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}</p>
    @endif
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

@if($order->line_items && count($order->line_items) > 0)
<h3>Items Shipped:</h3>
@foreach($order->line_items as $item)
    <div class="order-item" style="border-bottom: 1px solid #e5e7eb; padding: 10px 0;">
        <strong>{{ $item->product_name }}</strong><br>
        Quantity: {{ $item->quantity }}
    </div>
@endforeach
@endif

<p>Your order should arrive within the estimated delivery time for your selected shipping method. We'll send you another email when your order is delivered.</p>

<p>If you have any questions about your shipment or need assistance, please don't hesitate to contact us.</p>

<p>Thank you for your business!</p>
@endsection
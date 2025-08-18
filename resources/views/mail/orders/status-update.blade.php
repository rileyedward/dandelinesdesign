@extends('mail.layouts.base')

@section('title', 'Order Update - ' . $order->order_number)

@section('content')
<h2>Order Update for {{ $customerName }}</h2>

<p>Great news! Your order status has been updated.</p>

<div class="order-summary">
    <h3>Order #{{ $order->order_number }}</h3>
    
    <p><strong>Previous Status:</strong> {{ ucfirst($previousStatus) }}</p>
    <p><strong>New Status:</strong> <span style="color: #059669; font-weight: 600;">{{ ucfirst($newStatus) }}</span></p>
    
    <div class="divider"></div>
    
    <p>{{ $statusMessage }}</p>
</div>

@if($order->status === 'shipped' && $order->tracking_number)
<h3>Tracking Information</h3>
<p>Your tracking number is: <strong>{{ $order->tracking_number }}</strong></p>
@endif

@if($order->status === 'delivered')
<p>We hope you love your order! If you have a moment, we'd appreciate a review of your experience.</p>
@endif

@if($order->status === 'cancelled')
<p>If you have any questions about your cancellation or would like to place a new order, please contact us.</p>
@endif

@endsection
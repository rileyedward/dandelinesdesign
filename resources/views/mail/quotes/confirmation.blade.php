@extends('mail.layouts.base')

@section('title', 'Quote Request Received')

@section('content')
<h2>Thank you for your quote request, {{ $customerName }}!</h2>

<p>We've received your request for a custom quote and we're excited to work with you on your project. Our team will review the details and prepare a personalized quote for you.</p>

<div class="order-summary">
    <h3>Quote Request Details</h3>
    
    <p><strong>Service Type:</strong> {{ ucfirst($quoteRequest->service_type) }}</p>
    <p><strong>Event Date:</strong> {{ $quoteRequest->event_date ? \Carbon\Carbon::parse($quoteRequest->event_date)->format('F j, Y') : 'To be determined' }}</p>
    <p><strong>Budget Range:</strong> {{ $quoteRequest->budget_range ? '$' . $quoteRequest->budget_range : 'Not specified' }}</p>
    <p><strong>Submitted:</strong> {{ $quoteRequest->created_at->format('F j, Y \a\t g:i A') }}</p>
    
    @if($quoteRequest->guest_count)
        <p><strong>Guest Count:</strong> {{ $quoteRequest->guest_count }}</p>
    @endif
    
    @if($quoteRequest->venue)
        <p><strong>Venue:</strong> {{ $quoteRequest->venue }}</p>
    @endif
    
    @if($quoteRequest->phone_number)
        <p><strong>Phone:</strong> {{ $quoteRequest->phone_number }}</p>
    @endif
    
    <div class="divider"></div>
    
    <p><strong>Project Description:</strong></p>
    <p style="font-style: italic; background-color: #f9fafb; padding: 15px; border-left: 3px solid #ec4899;">
        {{ $quoteRequest->details }}
    </p>
</div>

<p>Our quotes are customized based on your specific needs and typically include:</p>
<ul style="color: #6b7280; padding-left: 20px;">
    <li>Detailed service breakdown</li>
    <li>Transparent pricing</li>
    <li>Timeline and delivery schedule</li>
    <li>Terms and conditions</li>
</ul>

<p>We'll have your personalized quote ready within 2-3 business days. If you have any additional questions or need to modify your request, please don't hesitate to contact us.</p>

<a href="{{ config('app.url') }}/contact" class="button">Contact Us</a>
@endsection
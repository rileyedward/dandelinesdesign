@extends('mail.layouts.base')

@section('title', 'Thank you for contacting us')

@section('content')
<h2>Thank you for reaching out, {{ $customerName }}!</h2>

<p>We've received your message and appreciate you taking the time to contact Dandelines Design. Our team will review your inquiry and get back to you as soon as possible.</p>

<div class="order-summary">
    <h3>Your Message Details</h3>
    
    <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
    <p><strong>Sent:</strong> {{ $contactMessage->created_at->format('F j, Y \a\t g:i A') }}</p>
    
    @if($contactMessage->business_name)
        <p><strong>Business:</strong> {{ $contactMessage->business_name }}</p>
    @endif
    
    @if($contactMessage->phone_number)
        <p><strong>Phone:</strong> {{ $contactMessage->phone_number }}</p>
    @endif
    
    <div class="divider"></div>
    
    <p><strong>Your Message:</strong></p>
    <p style="font-style: italic; background-color: #f9fafb; padding: 15px; border-left: 3px solid #ec4899;">
        {{ $contactMessage->message }}
    </p>
</div>

<p>Our typical response time is within 24-48 hours during business days. If your inquiry is urgent, please feel free to call us directly.</p>

<p>In the meantime, feel free to browse our portfolio and services on our website.</p>

<a href="{{ config('app.url') }}" class="button">Visit Our Website</a>
@endsection
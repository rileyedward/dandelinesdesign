<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Image;
use App\Models\Lead;
use App\Models\NewsletterSubscriber;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $metrics = [
            'newLeads' => Lead::where('status', 'new')->count(),
            'pendingQuotes' => QuoteRequest::where('status', 'pending')->count(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'totalProducts' => Product::where('is_active', true)->count(),
            'totalSubscribers' => NewsletterSubscriber::where('status', 'active')->count(),
            'totalTestimonials' => Testimonial::where('is_active', true)->count(),
            'totalImages' => Image::count(),
        ];

        return inertia('admin/admin-dashboard', [
            'metrics' => $metrics
        ]);
    }
}

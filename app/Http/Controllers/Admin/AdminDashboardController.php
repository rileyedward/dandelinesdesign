<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Image;
use App\Models\Lead;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
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
            'newLeads' => Lead::query()->where('status', 'new')->count(),
            'pendingQuotes' => QuoteRequest::query()->where('status', 'pending')->count(),
            'unreadMessages' => ContactMessage::query()->where('is_read', false)->count(),
            'totalProducts' => Product::query()->where('is_active', true)->count(),
            'totalSubscribers' => NewsletterSubscriber::query()->where('status', 'active')->count(),
            'totalTestimonials' => Testimonial::query()->where('is_active', true)->count(),
            'totalImages' => Image::query()->count(),

            'totalOrders' => Order::query()->count(),
            'pendingOrders' => Order::query()->where('status', 'pending')->count(),
            'processingOrders' => Order::query()->where('status', 'processing')->count(),
            'totalRevenue' => Order::query()->where('payment_status', 'paid')->sum('total_amount'),
            'recentOrders' => Order::query()->orderBy('created_at', 'desc')->take(5)->get(),
        ];

        return inertia('admin/admin-dashboard', [
            'metrics' => $metrics,
        ]);
    }
}

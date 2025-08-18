<?php

namespace App\Providers;

use App\Contracts\BlogPostRepositoryInterface;
use App\Contracts\BlogPostServiceInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\CategoryServiceInterface;
use App\Contracts\ContactMessageRepositoryInterface;
use App\Contracts\ContactMessageServiceInterface;
use App\Contracts\LeadRepositoryInterface;
use App\Contracts\LeadServiceInterface;
use App\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Contracts\NewsletterSubscriberServiceInterface;
use App\Contracts\NewsletterTemplateRepositoryInterface;
use App\Contracts\NewsletterTemplateServiceInterface;
use App\Contracts\NotificationRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;
use App\Contracts\QuoteRequestRepositoryInterface;
use App\Contracts\QuoteRequestServiceInterface;
use App\Contracts\TestimonialRepositoryInterface;
use App\Contracts\TestimonialServiceInterface;
use App\Models\ContactMessage;
use App\Models\Lead;
use App\Models\Order;
use App\Models\QuoteRequest;
use App\Observers\ContactMessageObserver;
use App\Observers\LeadObserver;
use App\Observers\OrderObserver;
use App\Observers\QuoteRequestObserver;
use App\Repositories\BlogPostRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ContactMessageRepository;
use App\Repositories\LeadRepository;
use App\Repositories\NewsletterSubscriberRepository;
use App\Repositories\NewsletterTemplateRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QuoteRequestRepository;
use App\Repositories\TestimonialRepository;
use App\Services\BlogPostService;
use App\Services\CategoryService;
use App\Services\ContactMessageService;
use App\Services\EmailService;
use App\Services\LeadService;
use App\Services\NewsletterSubscriberService;
use App\Services\NewsletterTemplateService;
use App\Services\NotificationService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\QuoteRequestService;
use App\Services\TestimonialService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Contact Messages
        $this->app->bind(ContactMessageRepositoryInterface::class, ContactMessageRepository::class);
        $this->app->bind(ContactMessageServiceInterface::class, ContactMessageService::class);

        // Blog Posts
        $this->app->bind(BlogPostRepositoryInterface::class, BlogPostRepository::class);
        $this->app->bind(BlogPostServiceInterface::class, BlogPostService::class);

        // Quote Requests
        $this->app->bind(QuoteRequestRepositoryInterface::class, QuoteRequestRepository::class);
        $this->app->bind(QuoteRequestServiceInterface::class, QuoteRequestService::class);

        // Testimonials
        $this->app->bind(TestimonialRepositoryInterface::class, TestimonialRepository::class);
        $this->app->bind(TestimonialServiceInterface::class, TestimonialService::class);

        // Leads
        $this->app->bind(LeadRepositoryInterface::class, LeadRepository::class);
        $this->app->bind(LeadServiceInterface::class, LeadService::class);

        // Categories
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);

        // Products
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        // Orders
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        // Notifications
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);

        // Newsletter Subscribers
        $this->app->bind(NewsletterSubscriberRepositoryInterface::class, NewsletterSubscriberRepository::class);
        $this->app->bind(NewsletterSubscriberServiceInterface::class, NewsletterSubscriberService::class);

        // Newsletter Templates
        $this->app->bind(NewsletterTemplateRepositoryInterface::class, NewsletterTemplateRepository::class);
        $this->app->bind(NewsletterTemplateServiceInterface::class, NewsletterTemplateService::class);

        // Email Service
        $this->app->singleton(EmailService::class);
    }

    public function boot(): void
    {
        ContactMessage::observe(ContactMessageObserver::class);
        QuoteRequest::observe(QuoteRequestObserver::class);
        Lead::observe(LeadObserver::class);
        Order::observe(OrderObserver::class);
    }
}

<?php

namespace App\Providers;

use App\Contracts\BlogPostRepositoryInterface;
use App\Contracts\BlogPostServiceInterface;
use App\Contracts\ContactMessageRepositoryInterface;
use App\Contracts\ContactMessageServiceInterface;
use App\Contracts\LeadRepositoryInterface;
use App\Contracts\LeadServiceInterface;
use App\Contracts\QuoteRequestRepositoryInterface;
use App\Contracts\QuoteRequestServiceInterface;
use App\Contracts\TestimonialRepositoryInterface;
use App\Contracts\TestimonialServiceInterface;
use App\Repositories\BlogPostRepository;
use App\Repositories\ContactMessageRepository;
use App\Repositories\LeadRepository;
use App\Repositories\QuoteRequestRepository;
use App\Repositories\TestimonialRepository;
use App\Services\BlogPostService;
use App\Services\ContactMessageService;
use App\Services\LeadService;
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
    }

    public function boot(): void
    {
        //
    }
}

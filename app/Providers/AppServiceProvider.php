<?php

namespace App\Providers;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Contracts\ContactMessageServiceInterface;
use App\Repositories\ContactMessageRepository;
use App\Services\ContactMessageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Contact Messages
        $this->app->bind(ContactMessageRepositoryInterface::class, ContactMessageRepository::class);
        $this->app->bind(ContactMessageServiceInterface::class, ContactMessageService::class);
    }

    public function boot(): void
    {
        //
    }
}

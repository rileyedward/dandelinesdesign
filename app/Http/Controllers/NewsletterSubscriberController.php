<?php

namespace App\Http\Controllers;

use App\Contracts\NewsletterSubscriberServiceInterface;
use App\Http\Requests\NewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Inertia\Response;

class NewsletterSubscriberController extends BaseController
{
    protected string $modelClass = NewsletterSubscriber::class;
    protected $serviceInterface = NewsletterSubscriberServiceInterface::class;
    protected ?string $requestClass = NewsletterSubscriberRequest::class;


    public function index(Request $request): Response
    {
        $activeSubscribers = NewsletterSubscriber::query()
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        $inactiveSubscribers = NewsletterSubscriber::query()
            ->where('status', 'inactive')
            ->orderBy('created_at', 'desc')
            ->get();
        $unsubscribedSubscribers = NewsletterSubscriber::query()
            ->where('status', 'unsubscribed')
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('admin/newsletter-subscribers/newsletter-subscribers-index', [
            'activeSubscribers' => $activeSubscribers,
            'inactiveSubscribers' => $inactiveSubscribers,
            'unsubscribedSubscribers' => $unsubscribedSubscribers,
        ]);
    }
}

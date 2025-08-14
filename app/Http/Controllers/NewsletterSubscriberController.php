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
        // TODO: Implement frontend index view for newsletter subscribers
        return inertia(null);
    }
}
<?php

namespace App\Http\Controllers;

use App\Contracts\NewsletterTemplateServiceInterface;
use App\Http\Requests\NewsletterTemplateRequest;
use App\Models\NewsletterTemplate;
use Illuminate\Http\Request;
use Inertia\Response;

class NewsletterTemplateController extends BaseController
{
    protected string $modelClass = NewsletterTemplate::class;
    protected $serviceInterface = NewsletterTemplateServiceInterface::class;
    protected ?string $requestClass = NewsletterTemplateRequest::class;

    public function index(Request $request): Response
    {
        // TODO: Implement frontend index view for newsletter templates
        return inertia(null);
    }
}
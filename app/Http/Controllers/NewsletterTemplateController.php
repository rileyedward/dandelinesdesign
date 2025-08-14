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
        $newsletterTemplates = NewsletterTemplate::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('admin/newsletter-templates/newsletter-templates-index', [
            'newsletterTemplates' => $newsletterTemplates,
        ]);
    }

    public function create(Request $request): Response
    {
        return inertia('admin/newsletter-templates/newsletter-templates-create');
    }

    public function show(Request $request, int $id): Response
    {
        $newsletterTemplate = NewsletterTemplate::findOrFail($id);

        return inertia('admin/newsletter-templates/newsletter-templates-show', [
            'newsletterTemplate' => $newsletterTemplate,
        ]);
    }
}

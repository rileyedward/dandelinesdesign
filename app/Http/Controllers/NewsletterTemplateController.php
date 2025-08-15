<?php

namespace App\Http\Controllers;

use App\Contracts\NewsletterTemplateServiceInterface;
use App\Http\Requests\NewsletterTemplateRequest;
use App\Models\NewsletterTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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

    public function store(): RedirectResponse
    {
        if (! $this->requestClass) {
            throw new MethodNotAllowedHttpException([], 'Method not allowed');
        }

        $request = app($this->requestClass);
        $validatedData = $request->validated();

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('store', $this->modelClass);

        $storeData = $this->filterInputData($validatedData);
        $newsletterTemplate = $this->service->store($storeData);

        return to_route('admin.newsletter.templates.show', $newsletterTemplate->id);
    }

    public function show(Request $request, int $id): Response
    {
        $newsletterTemplate = NewsletterTemplate::findOrFail($id);

        return inertia('admin/newsletter-templates/newsletter-templates-show', [
            'newsletterTemplate' => $newsletterTemplate,
        ]);
    }

    public function send(int $id): RedirectResponse
    {
        $newsletterTemplate = NewsletterTemplate::query()->findOrFail($id);

        // TODO: Mail integration...

        $newsletterTemplate->status = 'sent';
        $newsletterTemplate->sent_at = now();
        // TODO: Modify the recipients count after mail integration...
        $newsletterTemplate->save();

        return to_route('admin.newsletter.templates.show', $newsletterTemplate->id);
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->service->getById($id);

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('destroy', $model);

        $this->service->delete($model);

        return to_route('admin.newsletter.templates.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Contracts\LeadServiceInterface;
use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class LeadController extends BaseController
{
    protected string $modelClass = Lead::class;

    protected $serviceInterface = LeadServiceInterface::class;

    protected ?string $requestClass = LeadRequest::class;

    public function index(Request $request): Response
    {
        $leads = Lead::query()
            ->orderBy('updated_at', 'desc')
            ->get();

        return inertia('admin/leads/leads-index', [
            'leads' => $leads,
        ]);
    }

    public function store(): RedirectResponse
    {
        if (! $this->requestClass) {
            throw new MethodNotAllowedHttpException([], 'Method not allowed');
        }

        $request = app($this->requestClass);
        $validatedData = $request->validated();
        $storeData = $this->filterInputData($validatedData);

        $lead = $this->service->store($storeData);

        return to_route('admin.leads.show', ['id' => $lead->id]);
    }

    public function show(Request $request, int $id): Response
    {
        $lead = Lead::query()->findOrFail($id);

        return inertia('admin/leads/leads-show', [
            'lead' => $lead,
        ]);
    }
}

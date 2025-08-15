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
        $newLeads = Lead::query()
            ->where('status', 'new')
            ->orderBy('created_at', 'desc')
            ->get();
        $contactedLeads = Lead::query()
            ->where('status', 'contacted')
            ->orderBy('created_at', 'desc')
            ->get();
        $qualifiedLeads = Lead::query()
            ->where('status', 'qualified')
            ->orderBy('created_at', 'desc')
            ->get();
        $proposalLeads = Lead::query()
            ->where('status', 'proposal')
            ->orderBy('created_at', 'desc')
            ->get();
        $wonLeads = Lead::query()
            ->where('status', 'won')
            ->orderBy('created_at', 'desc')
            ->get();
        $lostLeads = Lead::query()
            ->where('status', 'lost')
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('admin/leads/leads-index', [
            'newLeads' => $newLeads,
            'contactedLeads' => $contactedLeads,
            'qualifiedLeads' => $qualifiedLeads,
            'proposalLeads' => $proposalLeads,
            'wonLeads' => $wonLeads,
            'lostLeads' => $lostLeads,
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

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->service->getById($id);

        // TODO: Uncomment once authorization policy structure is setup...
        // $this->authorize('destroy', $model);

        $this->service->delete($model);

        return to_route('admin.leads.index');
    }
}

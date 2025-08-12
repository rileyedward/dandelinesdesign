<?php

namespace App\Http\Controllers;

use App\Contracts\LeadServiceInterface;
use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use Illuminate\Http\Request;
use Inertia\Response;

class LeadController extends BaseController
{
    protected string $modelClass = Lead::class;

    protected $serviceInterface = LeadServiceInterface::class;

    protected ?string $requestClass = LeadRequest::class;

    public function index(Request $request): Response
    {
        $leads = Lead::query()->get();

        return inertia('admin/leads/leads-index', [
            'leads' => $leads,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $lead = Lead::findOrFail($id);
        
        return inertia('admin/leads/leads-show', [
            'lead' => $lead,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Contracts\QuoteRequestServiceInterface;
use App\Http\Requests\QuoteRequestRequest;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Inertia\Response;

class QuoteRequestController extends BaseController
{
    protected string $modelClass = QuoteRequest::class;

    protected $serviceInterface = QuoteRequestServiceInterface::class;

    protected ?string $requestClass = QuoteRequestRequest::class;

    public function index(Request $request): Response
    {
        $pendingRequests = QuoteRequest::query()->where('status', 'pending')->get();
        $contactedRequests = QuoteRequest::query()->where('status', 'contacted')->get();
        $quotedRequests = QuoteRequest::query()->where('status', 'quoted')->get();
        $completedRequests = QuoteRequest::query()->where('status', 'completed')->get();
        $cancelledRequests = QuoteRequest::query()->where('status', 'cancelled')->get();

        return inertia('admin/quote-requests/quote-requests-index', [
            'pendingRequests' => $pendingRequests,
            'contactedRequests' => $contactedRequests,
            'quotedRequests' => $quotedRequests,
            'completedRequests' => $completedRequests,
            'cancelledRequests' => $cancelledRequests,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        return inertia('admin/quote-requests/quote-requests-show');
    }
}

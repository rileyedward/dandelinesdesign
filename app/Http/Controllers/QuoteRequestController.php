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
        $pendingRequests = QuoteRequest::query()
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        $contactedRequests = QuoteRequest::query()
            ->where('status', 'contacted')
            ->orderBy('created_at', 'desc')
            ->get();
        $quotedRequests = QuoteRequest::query()
            ->where('status', 'quoted')
            ->orderBy('created_at', 'desc')
            ->get();
        $completedRequests = QuoteRequest::query()
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
        $cancelledRequests = QuoteRequest::query()
            ->where('status', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

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

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
        return inertia('admin/quote-requests/quote-requests-index');
    }

    public function show(Request $request, int $id): Response
    {
        return inertia('admin/quote-requests/quote-requests-show');
    }
}

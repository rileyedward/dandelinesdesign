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
        // TODO: Add page route...
        return inertia(null);
    }
}

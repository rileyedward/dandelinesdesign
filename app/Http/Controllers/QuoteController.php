<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use Inertia\Response;

class QuoteController extends Controller
{
    public function store(QuoteRequest $request): Response
    {
        return response()->back();
    }
}

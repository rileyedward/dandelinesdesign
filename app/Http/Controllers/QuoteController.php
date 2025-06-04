<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteMessageRequest;
use App\Models\QuoteMessage;
use Inertia\Response;

class QuoteController extends Controller
{
    public function store(QuoteMessageRequest $request): Response
    {
        QuoteMessage::query()->create($request->validated());

        return response()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteMessageRequest;
use App\Models\QuoteMessage;
use Illuminate\Http\RedirectResponse;

class QuoteController extends Controller
{
    public function store(QuoteMessageRequest $request): RedirectResponse
    {
        QuoteMessage::query()->create($request->validated());

        return redirect()->back();
    }
}

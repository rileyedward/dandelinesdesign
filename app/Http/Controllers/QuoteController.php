<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteMessageRequest;
use App\Models\QuoteMessage;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class QuoteController extends Controller
{
    public function admin(): Response
    {
        // TODO: Add authorization policy...

        $quoteMessages = QuoteMessage::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-quotes', [
            'quoteMessages' => $quoteMessages,
        ]);
    }

    public function store(QuoteMessageRequest $request): RedirectResponse
    {
        QuoteMessage::query()->create($request->validated());

        return redirect()->back();
    }

    public function destroy(QuoteMessage $quoteMessage): RedirectResponse
    {
        // TODO: Add authorization policy...

        $quoteMessage->delete();

        return redirect()->back();
    }
}

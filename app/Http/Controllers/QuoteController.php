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
        $unreadMessages = QuoteMessage::query()
            ->orderBy('created_at', 'desc')
            ->get();

        $readMessages = QuoteMessage::query()
            ->onlyTrashed()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-quotes', [
            'unreadMessages' => $unreadMessages,
            'readMessages' => $readMessages,
        ]);
    }

    public function store(QuoteMessageRequest $request): RedirectResponse
    {
        QuoteMessage::query()->create($request->validated());

        return redirect()->back();
    }

    public function destroy(QuoteMessage $quote): RedirectResponse
    {
        $quote->delete();

        logger()->info('here');

        return redirect()->back();
    }
}

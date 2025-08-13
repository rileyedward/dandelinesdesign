<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\QuoteRequest;

class QuoteRequestObserver
{
    public function created(QuoteRequest $quoteRequest): void
    {
        Notification::query()->create([
            'type' => 'success',
            'title' => 'New Quote Request',
            'message' => "A new quote request has been submitted by {$quoteRequest->name}",
            'action_url' => route('admin.quotes.index'),
            'action_text' => 'View Quotes',
        ]);
    }
}

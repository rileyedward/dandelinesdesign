<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\QuoteRequest;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class QuoteRequestObserver
{
    public function __construct(
        private EmailService $emailService
    ) {}

    public function created(QuoteRequest $quoteRequest): void
    {
        Notification::query()->create([
            'type' => 'success',
            'title' => 'New Quote Request',
            'message' => "A new quote request has been submitted by {$quoteRequest->name}",
            'action_url' => route('admin.quotes.index'),
            'action_text' => 'View Quotes',
        ]);

        try {
            $this->emailService->sendQuoteRequestConfirmation($quoteRequest);
        } catch (\Exception $e) {
            Log::error('Failed to send quote request confirmation email in observer', [
                'quote_request_id' => $quoteRequest->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

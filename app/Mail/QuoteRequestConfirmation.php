<?php

namespace App\Mail;

use App\Models\QuoteRequest;

class QuoteRequestConfirmation extends BaseMailable
{
    protected string $viewName = 'mail.quotes.confirmation';

    public function __construct(
        public QuoteRequest $quoteRequest
    ) {
        $this->viewData = [
            'quoteRequest' => $this->quoteRequest,
            'customerName' => $this->quoteRequest->name,
        ];
    }

    protected function getSubject(): string
    {
        return 'Quote Request Received - Dandelines Design';
    }
}

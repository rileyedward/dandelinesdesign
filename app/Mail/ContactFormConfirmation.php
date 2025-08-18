<?php

namespace App\Mail;

use App\Models\ContactMessage;

class ContactFormConfirmation extends BaseMailable
{
    protected string $viewName = 'mail.contact.confirmation';

    public function __construct(
        public ContactMessage $contactMessage
    ) {
        $this->viewData = [
            'contactMessage' => $this->contactMessage,
            'customerName' => $this->contactMessage->name,
        ];
    }

    protected function getSubject(): string
    {
        return 'Thank you for contacting Dandelines Design';
    }
}

<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Models\Notification;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class ContactMessageObserver
{
    public function __construct(
        private EmailService $emailService
    ) {}

    public function created(ContactMessage $contactMessage): void
    {
        Notification::query()->create([
            'type' => 'info',
            'title' => 'New Contact Message',
            'message' => "A new contact message has been received from {$contactMessage->name}",
            'action_url' => route('admin.messages.index'),
            'action_text' => 'View Messages',
        ]);

        try {
            $this->emailService->sendContactFormConfirmation($contactMessage);
        } catch (\Exception $e) {
            Log::error('Failed to send contact form confirmation email in observer', [
                'contact_message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

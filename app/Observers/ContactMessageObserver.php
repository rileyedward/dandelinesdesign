<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Models\Notification;

class ContactMessageObserver
{
    public function created(ContactMessage $contactMessage): void
    {
        Notification::query()->create([
            'type' => 'info',
            'title' => 'New Contact Message',
            'message' => "A new contact message has been received from {$contactMessage->name}",
            'action_url' => route('admin.messages.index'),
            'action_text' => 'View Messages',
        ]);
    }
}

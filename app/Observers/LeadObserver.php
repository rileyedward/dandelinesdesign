<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Notification;

class LeadObserver
{
    public function updated(Lead $lead): void
    {
        if ($lead->isDirty('status')) {
            Notification::query()->create([
                'type' => 'primary',
                'title' => 'Lead Status Updated',
                'message' => "Lead {$lead->name} status updated to {$lead->status}",
                'action_url' => route('admin.leads.show', $lead->id),
                'action_text' => 'View Lead',
            ]);
        }
    }
}

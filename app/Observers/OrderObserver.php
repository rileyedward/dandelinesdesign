<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function __construct(
        private EmailService $emailService
    ) {}

    public function created(Order $order): void
    {
        try {
            $this->emailService->sendOrderConfirmation($order);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email in observer', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function updating(Order $order): void
    {
        if ($order->isDirty('status')) {
            $order->original_status = $order->getOriginal('status');
        }
    }

    public function updated(Order $order): void
    {
        if ($order->wasChanged('status') && isset($order->original_status)) {
            try {
                $this->emailService->sendOrderStatusUpdate($order, $order->original_status);
            } catch (\Exception $e) {
                Log::error('Failed to send order status update email in observer', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}

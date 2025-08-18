<?php

namespace App\Services;

use App\Mail\ContactFormConfirmation;
use App\Mail\OrderConfirmation;
use App\Mail\OrderShipped;
use App\Mail\OrderStatusUpdate;
use App\Mail\QuoteRequestConfirmation;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendOrderConfirmation(Order $order): bool
    {
        try {
            if (! $order->customer_email) {
                Log::warning('Cannot send order confirmation: no customer email', ['order_id' => $order->id]);

                return false;
            }

            Mail::to($order->customer_email)
                ->queue(new OrderConfirmation($order));

            Log::info('Order confirmation email queued', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function sendOrderShipped(Order $order): bool
    {
        try {
            if (! $order->customer_email) {
                Log::warning('Cannot send order shipped email: no customer email', ['order_id' => $order->id]);

                return false;
            }

            Mail::to($order->customer_email)
                ->queue(new OrderShipped($order));

            Log::info('Order shipped email queued', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
                'tracking_number' => $order->tracking_number,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function sendOrderStatusUpdate(Order $order, string $previousStatus): bool
    {
        try {
            if (! $order->customer_email) {
                Log::warning('Cannot send order status update: no customer email', ['order_id' => $order->id]);

                return false;
            }

            // Send specific shipped email for shipped status
            if ($order->status === 'shipped') {
                return $this->sendOrderShipped($order);
            }

            // Only send status updates for meaningful changes
            if ($this->shouldSendStatusUpdate($order->status, $previousStatus)) {
                Mail::to($order->customer_email)
                    ->queue(new OrderStatusUpdate($order, $previousStatus));

                Log::info('Order status update email queued', [
                    'order_id' => $order->id,
                    'email' => $order->customer_email,
                    'from_status' => $previousStatus,
                    'to_status' => $order->status,
                ]);

                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send order status update email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function sendContactFormConfirmation(ContactMessage $contactMessage): bool
    {
        try {
            if (! $contactMessage->email) {
                Log::warning('Cannot send contact confirmation: no email', ['contact_message_id' => $contactMessage->id]);

                return false;
            }

            Mail::to($contactMessage->email)
                ->queue(new ContactFormConfirmation($contactMessage));

            Log::info('Contact form confirmation email queued', [
                'contact_message_id' => $contactMessage->id,
                'email' => $contactMessage->email,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send contact form confirmation email', [
                'contact_message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function sendQuoteRequestConfirmation(QuoteRequest $quoteRequest): bool
    {
        try {
            if (! $quoteRequest->email) {
                Log::warning('Cannot send quote confirmation: no email', ['quote_request_id' => $quoteRequest->id]);

                return false;
            }

            Mail::to($quoteRequest->email)
                ->queue(new QuoteRequestConfirmation($quoteRequest));

            Log::info('Quote request confirmation email queued', [
                'quote_request_id' => $quoteRequest->id,
                'email' => $quoteRequest->email,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send quote request confirmation email', [
                'quote_request_id' => $quoteRequest->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    protected function shouldSendStatusUpdate(string $newStatus, string $previousStatus): bool
    {
        $importantStatuses = ['processing', 'shipped', 'delivered', 'cancelled'];

        return in_array($newStatus, $importantStatuses) && $newStatus !== $previousStatus;
    }
}

<?php

namespace App\Mail;

use App\Models\Order;

class OrderStatusUpdate extends BaseMailable
{
    protected string $viewName = 'mail.orders.status-update';

    public function __construct(
        public Order $order,
        public string $previousStatus
    ) {
        $this->viewData = [
            'order' => $this->order,
            'previousStatus' => $this->previousStatus,
            'newStatus' => $this->order->status,
            'customerName' => $this->getCustomerName(),
            'statusMessage' => $this->getStatusMessage(),
        ];
    }

    protected function getSubject(): string
    {
        $statusLabel = ucfirst($this->order->status);

        return "Order Update - {$this->order->order_number} is now {$statusLabel}";
    }

    private function getCustomerName(): string
    {
        $firstName = $this->order->customer_first_name ?? '';
        $lastName = $this->order->customer_last_name ?? '';

        return trim("$firstName $lastName") ?: $this->order->customer_email;
    }

    private function getStatusMessage(): string
    {
        return match ($this->order->status) {
            'processing' => 'Your order is being prepared for shipment.',
            'shipped' => 'Your order has been shipped and is on its way to you.',
            'delivered' => 'Your order has been delivered successfully.',
            'cancelled' => 'Your order has been cancelled.',
            default => 'Your order status has been updated.',
        };
    }
}

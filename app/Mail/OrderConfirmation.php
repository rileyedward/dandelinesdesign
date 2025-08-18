<?php

namespace App\Mail;

use App\Models\Order;

class OrderConfirmation extends BaseMailable
{
    protected string $viewName = 'mail.orders.confirmation';

    public function __construct(
        public Order $order
    ) {
        $this->viewData = [
            'order' => $this->order,
            'customerName' => $this->getCustomerName(),
            'orderTotal' => $this->formatCurrency($this->order->total_amount, $this->order->currency),
        ];
    }

    protected function getSubject(): string
    {
        return "Order Confirmation - {$this->order->order_number}";
    }

    private function getCustomerName(): string
    {
        $firstName = $this->order->customer_first_name ?? '';
        $lastName = $this->order->customer_last_name ?? '';

        return trim("$firstName $lastName") ?: $this->order->customer_email;
    }

    private function formatCurrency(float $amount, string $currency = 'USD'): string
    {
        return number_format($amount, 2);
    }
}

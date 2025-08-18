<?php

namespace App\Mail;

use App\Models\Order;

class OrderShipped extends BaseMailable
{
    protected string $viewName = 'mail.orders.shipped';

    public function __construct(
        public Order $order
    ) {
        $this->viewData = [
            'order' => $this->order,
            'customerName' => $this->getCustomerName(),
        ];
    }

    protected function getSubject(): string
    {
        return "Order Shipped - {$this->order->order_number}";
    }

    private function getCustomerName(): string
    {
        $firstName = $this->order->customer_first_name ?? '';
        $lastName = $this->order->customer_last_name ?? '';

        return trim("$firstName $lastName") ?: $this->order->customer_email;
    }
}
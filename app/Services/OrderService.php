<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;

class OrderService extends BaseService implements OrderServiceInterface
{
    public mixed $repository;
    public array $relations = ['lineItems', 'lineItems.product'];

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

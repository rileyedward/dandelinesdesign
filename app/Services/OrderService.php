<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;

class OrderService extends BaseService implements OrderServiceInterface
{
    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public array $relations = [
        'orderProducts',
        'orderProducts.product',
        'products',
    ];
}

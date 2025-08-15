<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public string $model = Order::class;
}

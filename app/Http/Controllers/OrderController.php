<?php

namespace App\Http\Controllers;

use App\Contracts\OrderServiceInterface;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    protected string $modelClass = Order::class;

    protected $serviceInterface = OrderServiceInterface::class;

    protected ?string $requestClass = OrderRequest::class;
}

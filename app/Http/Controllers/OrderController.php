<?php

namespace App\Http\Controllers;

use App\Contracts\OrderServiceInterface;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends BaseController
{
    protected string $modelClass = Order::class;

    protected $serviceInterface = OrderServiceInterface::class;

    protected ?string $requestClass = OrderRequest::class;

    public function index(): Response
    {
        $orders = Order::query()
            ->with('lineItems')
            ->orderBy('updated_at', 'desc')
            ->get();

        $statusCounts = $orders->groupBy('status')->map->count();
        $allCount = $orders->count();

        return Inertia::render('admin/orders/orders-index', [
            'orders' => $orders->values(),
            'statusCounts' => $statusCounts,
            'allCount' => $allCount,
        ]);
    }

    public function show(string $id): Response
    {
        $model = $this->service->getById($id);
        $model->load('lineItems');

        return Inertia::render('admin/orders/orders-show', [
            'order' => $model,
        ]);
    }
}

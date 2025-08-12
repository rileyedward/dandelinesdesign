<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
    public mixed $repository;

    public array $relations = ['category'];

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\CategoryServiceInterface;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public mixed $repository;

    public array $relations = ['products'];

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
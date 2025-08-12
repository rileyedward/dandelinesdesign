<?php

namespace App\Services;

use App\Contracts\BlogPostRepositoryInterface;
use App\Contracts\BlogPostServiceInterface;

class BlogPostService extends BaseService implements BlogPostServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(BlogPostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

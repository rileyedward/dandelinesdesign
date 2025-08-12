<?php

namespace App\Services;

use App\Contracts\TestimonialRepositoryInterface;
use App\Contracts\TestimonialServiceInterface;

class TestimonialService extends BaseService implements TestimonialServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(TestimonialRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

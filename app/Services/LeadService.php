<?php

namespace App\Services;

use App\Contracts\LeadRepositoryInterface;
use App\Contracts\LeadServiceInterface;

class LeadService extends BaseService implements LeadServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(LeadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

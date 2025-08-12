<?php

namespace App\Services;

use App\Contracts\QuoteRequestRepositoryInterface;
use App\Contracts\QuoteRequestServiceInterface;

class QuoteRequestService extends BaseService implements QuoteRequestServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(QuoteRequestRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

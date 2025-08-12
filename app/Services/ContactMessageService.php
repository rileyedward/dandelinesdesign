<?php

namespace App\Services;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Contracts\ContactMessageServiceInterface;

class ContactMessageService extends BaseService implements ContactMessageServiceInterface
{
    public mixed $repository;

    public array $relations = [];

    public function __construct(ContactMessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

<?php

namespace App\Services;

use App\Contracts\NotificationRepositoryInterface;
use App\Contracts\NotificationServiceInterface;

class NotificationService extends BaseService implements NotificationServiceInterface
{
    public mixed $repository;
    public array $relations = [];

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}

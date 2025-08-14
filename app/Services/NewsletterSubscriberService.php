<?php

namespace App\Services;

use App\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Contracts\NewsletterSubscriberServiceInterface;

class NewsletterSubscriberService extends BaseService implements NewsletterSubscriberServiceInterface
{
    public mixed $repository;
    public array $relations = [];

    public function __construct(NewsletterSubscriberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
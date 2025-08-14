<?php

namespace App\Services;

use App\Contracts\NewsletterTemplateRepositoryInterface;
use App\Contracts\NewsletterTemplateServiceInterface;

class NewsletterTemplateService extends BaseService implements NewsletterTemplateServiceInterface
{
    public mixed $repository;
    public array $relations = [];

    public function __construct(NewsletterTemplateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
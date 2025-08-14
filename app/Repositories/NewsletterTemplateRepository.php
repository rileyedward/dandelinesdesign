<?php

namespace App\Repositories;

use App\Contracts\NewsletterTemplateRepositoryInterface;
use App\Models\NewsletterTemplate;

class NewsletterTemplateRepository extends BaseRepository implements NewsletterTemplateRepositoryInterface
{
    public string $model = NewsletterTemplate::class;
}

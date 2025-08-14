<?php

namespace App\Repositories;

use App\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberRepository extends BaseRepository implements NewsletterSubscriberRepositoryInterface
{
    public string $model = NewsletterSubscriber::class;
}

<?php

namespace App\Repositories;

use App\Contracts\QuoteRequestRepositoryInterface;
use App\Models\QuoteRequest;

class QuoteRequestRepository extends BaseRepository implements QuoteRequestRepositoryInterface
{
    public string $model = QuoteRequest::class;
}

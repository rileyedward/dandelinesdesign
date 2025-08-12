<?php

namespace App\Repositories;

use App\Contracts\LeadRepositoryInterface;
use App\Models\Lead;

class LeadRepository extends BaseRepository implements LeadRepositoryInterface
{
    public string $model = Lead::class;
}

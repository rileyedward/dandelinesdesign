<?php

namespace App\Repositories;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Models\ContactMessage;

class ContactMessageRepository extends BaseRepository implements ContactMessageRepositoryInterface
{
    public string $model = ContactMessage::class;
}

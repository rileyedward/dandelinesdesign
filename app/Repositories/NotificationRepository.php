<?php

namespace App\Repositories;

use App\Contracts\NotificationRepositoryInterface;
use App\Models\Notification;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public string $model = Notification::class;
}

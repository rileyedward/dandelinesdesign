<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'action_url',
        'action_text',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterSubscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'status',
        'subscribed_at',
        'unsubscribed_at',
        'source',
        'preferences',
        'tags',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'preferences' => 'array',
        'tags' => 'array',
    ];
}

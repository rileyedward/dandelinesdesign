<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'newsletter_templates';

    protected $fillable = [
        'name',
        'subject',
        'content',
        'preview_text',
        'status',
        'scheduled_at',
        'sent_at',
        'recipients_count',
        'opens_count',
        'clicks_count',
        'tags',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'recipients_count' => 'integer',
        'opens_count' => 'integer',
        'clicks_count' => 'integer',
        'tags' => 'array',
        'metadata' => 'array',
    ];
}

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
        'status',
        'sent_at',
        'recipients_count',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'recipients_count' => 'integer',
    ];
}

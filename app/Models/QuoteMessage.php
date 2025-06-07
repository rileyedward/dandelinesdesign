<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quote_messages';

    protected $fillable = [
        'name',
        'business_name',
        'email',
        'phone',
        'event_date',
        'event_type',
        'event_description',
        'guest_count',
        'venue_name',
        'venue_address',
        'special_requests',
    ];
}

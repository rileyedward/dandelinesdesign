<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteMessage extends Model
{
    use HasFactory;

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
        'budget_range',
        'special_requests',
    ];
}

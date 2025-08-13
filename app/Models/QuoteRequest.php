<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quote_requests';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'service_type',
        'event_date',
        'event_location',
        'guest_count',
        'budget',
        'description',
        'status',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'budget' => 'decimal:2',
        'guest_count' => 'integer',
    ];
}

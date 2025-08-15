<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prices';

    protected $fillable = [
        'stripe_price_id',
        'product_id',
        'active',
        'currency',
        'type',
        'unit_amount',
        'unit_amount_decimal',
        'billing_scheme',
        'recurring',
        'usage_type',
        'tax_behavior',
        'nickname',
        'metadata',
        'stripe_created_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'unit_amount' => 'decimal:2',
        'unit_amount_decimal' => 'integer',
        'tax_behavior' => 'boolean',
        'recurring' => 'array',
        'metadata' => 'array',
        'stripe_created_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

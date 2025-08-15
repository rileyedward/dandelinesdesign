<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LineItem extends Model
{
    use HasFactory;

    protected $table = 'line_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'product_description',
        'product_image_url',
        'quantity',
        'unit_price',
        'total_price',
        'currency',
        'stripe_price_id',
        'stripe_product_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'order_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
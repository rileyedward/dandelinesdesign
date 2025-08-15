<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'stripe_product_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image_url',
        'images',
        'package_dimensions',
        'weight',
        'shippable',
        'tax_code',
        'metadata',
        'unit_label',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'shippable' => 'boolean',
        'weight' => 'decimal:2',
        'category_id' => 'integer',
        'images' => 'array',
        'metadata' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function activePrices(): HasMany
    {
        return $this->hasMany(Price::class)->where('active', true);
    }

    public function defaultPrice(): ?Price
    {
        return $this->activePrices()->first();
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->withPivot([
                'quantity',
                'unit_price',
            ])
            ->withTimestamps();
    }

    // Helper methods
    public function getFormattedPriceAttribute(): string
    {
        $defaultPrice = $this->defaultPrice();

        return $defaultPrice ? $defaultPrice->formatted_price : 'N/A';
    }

    public function getPrimaryImageAttribute(): ?string
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }

        return $this->image_url;
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }

    public function getIsShippableAttribute(): bool
    {
        return $this->shippable ?? true;
    }

    public function getTotalOrdersAttribute(): int
    {
        return $this->orderProducts()->distinct('order_id')->count('order_id');
    }

    public function getTotalQuantitySoldAttribute(): int
    {
        return $this->orderProducts()->sum('quantity');
    }

    public function getTotalRevenueAttribute(): float
    {
        return $this->orderProducts()->get()->sum('line_total');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeInPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereHas('prices', function ($priceQuery) use ($minPrice, $maxPrice) {
            $priceQuery->where('active', true)
                ->whereBetween('unit_amount', [$minPrice, $maxPrice]);
        });
    }

    public function scopeWithActivePrices($query)
    {
        return $query->with(['prices' => function ($priceQuery) {
            $priceQuery->where('active', true)->orderBy('unit_amount');
        }]);
    }

    // Static methods
    public static function findByStripeId(string $stripeProductId): ?self
    {
        return static::where('stripe_product_id', $stripeProductId)->first();
    }
}

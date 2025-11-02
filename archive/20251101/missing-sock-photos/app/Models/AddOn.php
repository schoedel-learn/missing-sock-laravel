<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_cents',
        'type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the price in dollars
     */
    public function getPriceAttribute(): float
    {
        return $this->price_cents / 100;
    }

    /**
     * Get the formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price_cents / 100, 2);
    }

    /**
     * Get all orders that have this add-on
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_add_ons')
            ->withPivot(['quantity', 'price_cents'])
            ->withTimestamps();
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_cents',
        'number_of_poses',
        'includes_prints',
        'includes_digital',
        'print_sizes',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'number_of_poses' => 'integer',
        'includes_prints' => 'boolean',
        'includes_digital' => 'boolean',
        'print_sizes' => 'array',
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
}


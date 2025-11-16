<?php

namespace App\Models;

use App\Traits\GeneratesUniqueNumbers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, GeneratesUniqueNumbers;

    protected $fillable = [
        'order_number',
        'user_id',
        'registration_id',
        'child_id',
        'main_package_id',
        'main_package_price_cents',
        'second_package_id',
        'second_package_price_cents',
        'third_package_id',
        'third_package_price_cents',
        'sibling_package_id',
        'sibling_package_price_cents',
        'sibling_special_fee_cents',
        'four_poses_upgrade',
        'four_poses_upgrade_price_cents',
        'pose_perfection',
        'pose_perfection_price_cents',
        'premium_retouch',
        'premium_retouch_price_cents',
        'retouch_specification',
        'class_picture_size',
        'class_picture_price_cents',
        'subtotal_cents',
        'shipping_cents',
        'discount_cents',
        'coupon_code',
        'total_cents',
    ];

    protected $casts = [
        'four_poses_upgrade' => 'boolean',
        'pose_perfection' => 'boolean',
        'premium_retouch' => 'boolean',
        'main_package_price_cents' => 'integer',
        'subtotal_cents' => 'integer',
        'total_cents' => 'integer',
    ];

    /**
     * Boot method to generate order number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        return static::generateUniqueNumber('ORD', 'order_number');
    }

    /**
     * Get the registration
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the child
     */
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Get the main package
     */
    public function mainPackage()
    {
        return $this->belongsTo(Package::class, 'main_package_id');
    }

    /**
     * Get the second package selection
     */
    public function secondPackage()
    {
        return $this->belongsTo(Package::class, 'second_package_id');
    }

    /**
     * Get the third package selection
     */
    public function thirdPackage()
    {
        return $this->belongsTo(Package::class, 'third_package_id');
    }

    /**
     * Get the sibling package selection
     */
    public function siblingPackage()
    {
        return $this->belongsTo(Package::class, 'sibling_package_id');
    }

    /**
     * Get add-ons
     */
    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'order_add_ons')
            ->withPivot(['quantity', 'price_cents'])
            ->withTimestamps();
    }

    /**
     * Get payments for this order
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get total in dollars
     */
    public function getTotalAttribute(): float
    {
        return $this->total_cents / 100;
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total_cents / 100, 2);
    }

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


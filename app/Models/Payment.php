<?php

namespace App\Models;

use App\Traits\GeneratesUniqueNumbers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, GeneratesUniqueNumbers;

    protected $fillable = [
        'registration_id',
        'order_id',
        'payment_number',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_customer_id',
        'amount_cents',
        'currency',
        'status',
        'card_brand',
        'card_last4',
        'paid_at',
        'failed_at',
        'refunded_at',
        'refund_amount_cents',
        'failure_code',
        'failure_message',
    ];

    protected $casts = [
        'amount_cents' => 'integer',
        'refund_amount_cents' => 'integer',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Boot method to generate payment number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            if (!$payment->payment_number) {
                $payment->payment_number = static::generatePaymentNumber();
            }
        });
    }

    /**
     * Generate unique payment number
     */
    public static function generatePaymentNumber(): string
    {
        return static::generateUniqueNumber('PAY', 'payment_number');
    }

    /**
     * Get the registration
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get amount in dollars
     */
    public function getAmountAttribute(): float
    {
        return $this->amount_cents / 100;
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount_cents / 100, 2);
    }
}


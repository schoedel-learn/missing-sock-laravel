<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlotBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_slot_id',
        'registration_id',
        'status',
        'cancelled_at',
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the time slot
     */
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    /**
     * Get the registration
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}


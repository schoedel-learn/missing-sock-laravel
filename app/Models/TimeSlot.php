<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'slot_datetime',
        'max_participants',
        'current_bookings',
        'is_available',
    ];

    protected $casts = [
        'slot_datetime' => 'datetime',
        'max_participants' => 'integer',
        'current_bookings' => 'integer',
        'is_available' => 'boolean',
    ];

    /**
     * Get the project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get all bookings
     */
    public function bookings()
    {
        return $this->hasMany(TimeSlotBooking::class);
    }

    /**
     * Check if time slot is available
     */
    public function isAvailable(): bool
    {
        return $this->is_available && $this->current_bookings < $this->max_participants;
    }
}


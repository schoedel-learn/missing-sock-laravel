<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'slug',
        'type',
        'available_backdrops',
        'has_two_backdrops',
        'registration_deadline',
        'session_date',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'available_backdrops' => 'array',
        'has_two_backdrops' => 'boolean',
        'is_active' => 'boolean',
        'registration_deadline' => 'date',
        'session_date' => 'date',
    ];

    /**
     * Get the school that owns this project
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get all registrations for this project
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get all time slots for this project
     */
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    /**
     * Get available time slots
     */
    public function availableTimeSlots()
    {
        return $this->hasMany(TimeSlot::class)
            ->where('is_available', true)
            ->whereRaw('current_bookings < max_participants')
            ->orderBy('slot_datetime');
    }
}


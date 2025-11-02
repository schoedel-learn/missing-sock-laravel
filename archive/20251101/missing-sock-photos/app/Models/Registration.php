<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_number',
        'school_id',
        'project_id',
        'parent_first_name',
        'parent_last_name',
        'parent_email',
        'parent_phone',
        'registration_type',
        'number_of_children',
        'sibling_special',
        'package_pose_distribution',
        'shipping_method',
        'shipping_address',
        'shipping_address_line2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'auto_select_images',
        'special_instructions',
        'email_opt_in',
        'signature_data',
        'signature_date',
        'status',
    ];

    protected $casts = [
        'number_of_children' => 'integer',
        'sibling_special' => 'boolean',
        'auto_select_images' => 'boolean',
        'email_opt_in' => 'boolean',
        'signature_date' => 'datetime',
    ];

    /**
     * Boot method to generate registration number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($registration) {
            if (!$registration->registration_number) {
                $registration->registration_number = static::generateRegistrationNumber();
            }
        });
    }

    /**
     * Generate unique registration number
     */
    public static function generateRegistrationNumber(): string
    {
        $year = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        
        return 'RG-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the school
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get all children for this registration
     */
    public function children()
    {
        return $this->hasMany(Child::class);
    }

    /**
     * Get all orders for this registration
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all payments for this registration
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the time slot booking
     */
    public function timeSlotBooking()
    {
        return $this->hasOne(TimeSlotBooking::class);
    }
}


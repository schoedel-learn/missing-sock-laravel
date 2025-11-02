<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'state',
        'zip',
        'contact_name',
        'contact_email',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all projects for this school
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the current active project for this school
     */
    public function currentProject()
    {
        return $this->hasOne(Project::class)
            ->where('is_active', true)
            ->latest('registration_deadline');
    }

    /**
     * Get all registrations for this school
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}


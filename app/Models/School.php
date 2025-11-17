<?php

namespace App\Models;

use App\Enums\OrganizationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'organization_type',
        'organization_label',
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
        'organization_type' => OrganizationType::class,
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

    public function coordinators()
    {
        return $this->belongsToMany(User::class, 'organization_user')->withTimestamps();
    }

    public function getDisplayOrganizationLabelAttribute(): string
    {
        if ($this->organization_label) {
            return $this->organization_label;
        }

        return $this->organization_type?->label() ?? OrganizationType::School->label();
    }
}

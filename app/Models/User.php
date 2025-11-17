<?php

namespace App\Models;

use App\Enums\UserRole;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function hasRole(UserRole $role): bool
    {
        return $this->role === $role;
    }

    public function hasElevatedAccess(): bool
    {
        return $this->role === UserRole::Admin || $this->role === UserRole::PhotoManager;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isPhotoManager(): bool
    {
        return $this->role === UserRole::PhotoManager;
    }

    public function isOrganizationCoordinator(): bool
    {
        return $this->role === UserRole::OrganizationCoordinator;
    }

    /**
     * Get all registrations for this user
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get all orders for this user
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all payments for this user (through orders)
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'organization_user')->withTimestamps();
    }

    public function managesOrganization(?int $organizationId): bool
    {
        if (!$organizationId || !$this->isOrganizationCoordinator()) {
            return false;
        }

        if ($this->relationLoaded('organizations')) {
            return $this->organizations->contains('id', $organizationId);
        }

        return $this->organizations()->where('school_id', $organizationId)->exists();
    }
}

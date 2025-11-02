<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegistrationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Admin only
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     * Public access allowed for confirmation pages (via registration number)
     */
    public function view(?User $user, Registration $registration): bool
    {
        // Allow public access - registration confirmation pages are accessible via registration number
        // In production, you may want to add additional checks (e.g., email verification token)
        return true;
    }

    /**
     * Determine whether the user can create models.
     * Public registration is allowed
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Registration $registration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Registration $registration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Registration $registration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Registration $registration): bool
    {
        return false;
    }
}

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
        if (!$user) {
            return false;
        }

        return $user->hasElevatedAccess() || $user->isOrganizationCoordinator();
    }

    /**
     * Determine whether the user can view the model.
     * Public access allowed for confirmation pages (via registration number)
     */
    public function view(?User $user, Registration $registration): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->hasElevatedAccess()) {
            return true;
        }

        if ($user->managesOrganization($registration->school_id)) {
            return true;
        }

        return $registration->user_id === $user->id;
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

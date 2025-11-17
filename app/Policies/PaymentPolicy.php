<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
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
     * Payments are sensitive - restrict to admin or registration owner
     */
    public function view(?User $user, Payment $payment): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->hasElevatedAccess()) {
            return true;
        }

        $schoolId = $payment->registration?->school_id ?? $payment->order?->registration?->school_id;

        if ($user->managesOrganization($schoolId)) {
            return true;
        }

        return $payment->user_id === $user->id
            || $payment->registration?->user_id === $user->id
            || $payment->order?->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return false;
    }
}

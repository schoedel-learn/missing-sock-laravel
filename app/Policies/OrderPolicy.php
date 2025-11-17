<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
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
     * Allow access if user owns the registration or is admin
     */
    public function view(?User $user, Order $order): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->hasElevatedAccess()) {
            return true;
        }

        $schoolId = $order->registration?->school_id;

        if ($user->managesOrganization($schoolId)) {
            return true;
        }

        return $order->user_id === $user->id || $order->registration?->user_id === $user->id;
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
    public function update(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}

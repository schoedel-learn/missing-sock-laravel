<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAccountService
{
    /**
     * Get or create a user account by email
     * If user exists, return it. If not, create a new account with a random password.
     * The user will need to set their password via password reset.
     *
     * @param string $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @return User
     */
    public function getOrCreateUser(string $email, ?string $firstName = null, ?string $lastName = null): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Create new user with random password
            // User will need to set password via password reset
            $name = trim(($firstName ?? '') . ' ' . ($lastName ?? ''));
            $name = $name ?: 'Customer';

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(32)), // Random password, user must reset
                'role' => UserRole::Parent->value,
                'email_verified_at' => null, // Email not verified yet
            ]);
        } else {
            // Update name if provided and current name is generic
            if ($firstName && $lastName) {
                $name = trim("{$firstName} {$lastName}");
                if ($name && ($user->name === 'Customer' || empty($user->name))) {
                    $user->update(['name' => $name]);
                }
            }

            if ($user->role === null) {
                $user->update(['role' => UserRole::Parent->value]);
            }
        }

        return $user;
    }

    /**
     * Send password reset email to user
     * This allows users to set their password after account creation
     *
     * @param User $user
     * @return void
     */
    public function sendPasswordReset(User $user): void
    {
        // Laravel's password reset will be handled by Filament's password reset feature
        // This method is here for future customization if needed
    }
}

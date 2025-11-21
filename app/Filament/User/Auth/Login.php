<?php

namespace App\Filament\User\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Welcome Back!';
    }

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return 'Sign in to view your orders, registrations, and photo galleries';
    }
}


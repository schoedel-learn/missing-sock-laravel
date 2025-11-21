<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Administrator Login';
    }

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return 'Access the full administration panel';
    }
}


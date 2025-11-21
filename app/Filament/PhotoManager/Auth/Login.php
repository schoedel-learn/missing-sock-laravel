<?php

namespace App\Filament\PhotoManager\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Photo Manager Login';
    }

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return 'Manage photo galleries, orders, and production workflows';
    }
}


<?php

namespace App\Filament\Coordinator\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Organization Coordinator Login';
    }

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return 'Access your organization\'s picture day management portal';
    }
}


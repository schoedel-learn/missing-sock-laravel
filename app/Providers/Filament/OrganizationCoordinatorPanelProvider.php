<?php

namespace App\Providers\Filament;

use App\Enums\UserRole;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class OrganizationCoordinatorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('coordinator')
            ->path('coordinator')
            ->login(\App\Filament\Coordinator\Auth\Login::class)
            ->passwordReset()
            ->profile()
            ->colors([
                'primary' => Color::hex('#FF5E3F'), // Coral Orange
            ])
            ->brandName('The Missing Sock Photography')
            ->brandLogo(asset('assets/logos/LOGO_LOGOLARGE-74.webp'))
            ->favicon(asset('favicon.ico'))
            ->discoverResources(in: app_path('Filament/Coordinator/Resources'), for: 'App\\Filament\\Coordinator\\Resources')
            ->discoverPages(in: app_path('Filament/Coordinator/Pages'), for: 'App\\Filament\\Coordinator\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Coordinator/Widgets'), for: 'App\\Filament\\Coordinator\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}


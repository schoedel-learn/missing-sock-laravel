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

class PhotoManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('photo-manager')
            ->path('photo-manager')
            ->login(\App\Filament\PhotoManager\Auth\Login::class)
            ->passwordReset()
            ->profile()
            ->colors([
                'primary' => Color::hex('#FF5E3F'), // Coral Orange
            ])
            ->brandName('The Missing Sock Photography')
            ->brandLogo(asset('assets/logos/LOGO_LOGOLARGE-74.webp'))
            ->favicon(asset('favicon.ico'))
            ->discoverResources(in: app_path('Filament/PhotoManager/Resources'), for: 'App\\Filament\\PhotoManager\\Resources')
            ->discoverPages(in: app_path('Filament/PhotoManager/Pages'), for: 'App\\Filament\\PhotoManager\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/PhotoManager/Widgets'), for: 'App\\Filament\\PhotoManager\\Widgets')
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


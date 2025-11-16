<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OrdersStatsWidget;
use App\Filament\Widgets\RecentOrdersWidget;
use App\Filament\Widgets\RegistrationsStatsWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected function getHeaderWidgets(): array
    {
        return [
            OrdersStatsWidget::class,
            RegistrationsStatsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RecentOrdersWidget::class,
        ];
    }
}


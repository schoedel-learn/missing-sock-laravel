<?php

namespace App\Filament\User\Pages;

use App\Filament\User\Widgets\MyOrdersWidget;
use App\Filament\User\Widgets\MyRegistrationsWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected function getHeaderWidgets(): array
    {
        return [
            MyRegistrationsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MyOrdersWidget::class,
        ];
    }
}


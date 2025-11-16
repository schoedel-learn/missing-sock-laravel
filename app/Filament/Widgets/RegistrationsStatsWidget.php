<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class RegistrationsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRegistrations = Registration::count();
        $todayRegistrations = Registration::whereDate('created_at', today())->count();
        $thisWeekRegistrations = Registration::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $thisMonthRegistrations = Registration::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total Registrations', Number::format($totalRegistrations))
                ->description('All time')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            
            Stat::make('Today', Number::format($todayRegistrations))
                ->description('New registrations today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            
            Stat::make('This Week', Number::format($thisWeekRegistrations))
                ->description('Registrations this week')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
            
            Stat::make('This Month', Number::format($thisMonthRegistrations))
                ->description('Registrations this month')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}


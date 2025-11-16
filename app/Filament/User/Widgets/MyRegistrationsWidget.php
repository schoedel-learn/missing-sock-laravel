<?php

namespace App\Filament\User\Widgets;

use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class MyRegistrationsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        $totalRegistrations = Registration::where('user_id', $userId)->count();
        $activeRegistrations = Registration::where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();
        $totalOrders = \App\Models\Order::where('user_id', $userId)->count();

        return [
            Stat::make('My Registrations', Number::format($totalRegistrations))
                ->description('Total registrations')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            
            Stat::make('Active Registrations', Number::format($activeRegistrations))
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Total Orders', Number::format($totalOrders))
                ->description('Orders placed')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
        ];
    }
}


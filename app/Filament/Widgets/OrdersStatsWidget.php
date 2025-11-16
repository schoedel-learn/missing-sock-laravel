<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrdersStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::whereNotNull('total_cents')->sum('total_cents') / 100;
        $todayOrders = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::whereDoesntHave('payments', function ($query) {
            $query->where('status', 'succeeded');
        })->count();

        return [
            Stat::make('Total Orders', Number::format($totalOrders))
                ->description('All time')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            
            Stat::make('Total Revenue', '$' . Number::format($totalRevenue, precision: 2))
                ->description('All time')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            
            Stat::make('Today\'s Orders', Number::format($todayOrders))
                ->description('New orders today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            
            Stat::make('Pending Orders', Number::format($pendingOrders))
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}


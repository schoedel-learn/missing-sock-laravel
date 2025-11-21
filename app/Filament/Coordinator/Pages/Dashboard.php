<?php

namespace App\Filament\Coordinator\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    
    protected static ?int $navigationSort = 1;
}


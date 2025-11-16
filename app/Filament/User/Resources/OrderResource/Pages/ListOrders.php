<?php

namespace App\Filament\User\Resources\OrderResource\Pages;

use App\Filament\User\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
}


<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->with(['registration', 'child', 'mainPackage'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration.parent_email')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('child.full_name')
                    ->label('Child')
                    ->placeholder('—'),
                TextColumn::make('mainPackage.name')
                    ->label('Package')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('total_cents')
                    ->label('Total')
                    ->money('usd')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}


<?php

namespace App\Filament\User\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class MyOrdersWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('user_id', Auth::id())
                    ->with(['registration', 'child', 'mainPackage'])
                    ->latest()
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
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
                TextColumn::make('payments.status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'succeeded' ? 'Paid' : 'Pending')
                    ->color(fn ($state): string => $state === 'succeeded' ? 'success' : 'warning'),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}


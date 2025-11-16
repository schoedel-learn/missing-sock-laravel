<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\OrderResource\Pages\ListOrders;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'My Orders';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'My Account';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('user_id', auth()->id())
                ->with(['registration', 'child', 'mainPackage', 'payments']);
            })
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('child.full_name')
                    ->label('Child')
                    ->placeholder('—'),
                \Filament\Tables\Columns\TextColumn::make('mainPackage.name')
                    ->label('Package')
                    ->badge()
                    ->color('primary'),
                \Filament\Tables\Columns\TextColumn::make('total_cents')
                    ->label('Total')
                    ->money('usd')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('payments.status')
                    ->label('Payment Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'succeeded' ? 'Paid' : 'Pending')
                    ->color(fn ($state): string => $state === 'succeeded' ? 'success' : 'warning'),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }
}


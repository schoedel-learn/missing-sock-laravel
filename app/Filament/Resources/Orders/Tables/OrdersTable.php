<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['registration', 'child', 'mainPackage']))
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration.registration_number')
                    ->label('Registration')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('child.full_name')
                    ->label('Child')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('mainPackage.name')
                    ->label('Main Package')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('four_poses_upgrade')
                    ->label('4 Poses')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('pose_perfection')
                    ->label('Pose Perfect')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('premium_retouch')
                    ->label('Retouch')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('subtotal_cents')
                    ->label('Subtotal')
                    ->sortable()
                    ->formatStateUsing(fn (?int $state) => $state === null ? '—' : '$' . number_format($state / 100, 2)),
                TextColumn::make('discount_cents')
                    ->label('Discounts')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn (?int $state) => $state ? '$' . number_format($state / 100, 2) : '$0.00'),
                TextColumn::make('shipping_cents')
                    ->label('Shipping')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn (?int $state) => $state ? '$' . number_format($state / 100, 2) : '$0.00'),
                TextColumn::make('total_cents')
                    ->label('Total')
                    ->sortable()
                    ->formatStateUsing(fn (?int $state) => $state === null ? '—' : '$' . number_format($state / 100, 2)),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->label('Deleted')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('main_package_id')
                    ->relationship('mainPackage', 'name')
                    ->label('Main Package'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}

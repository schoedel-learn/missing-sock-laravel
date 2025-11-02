<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Overview')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                TextInput::make('order_number')
                                    ->label('Order #')
                                    ->readOnly()
                                    ->helperText('Automatically generated when the order is saved.')
                                    ->placeholder('Will be generated on save'),
                                Select::make('registration_id')
                                    ->label('Registration')
                                    ->relationship('registration', 'registration_number')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(1),
                                Select::make('child_id')
                                    ->label('Child')
                                    ->relationship('child', 'full_name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Optional')
                                    ->columnSpan(1),
                            ]),
                    ]),
                Section::make('Packages & Pricing')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('main_package_id')
                                    ->label('Main Package')
                                    ->relationship('mainPackage', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                self::moneyInput('main_package_price_cents')
                                    ->label('Main Package Price')
                    ->required(),
                                Select::make('second_package_id')
                                    ->label('Second Package')
                                    ->relationship('secondPackage', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('None'),
                                self::moneyInput('second_package_price_cents')
                                    ->label('Second Package Price'),
                                Select::make('third_package_id')
                                    ->label('Third Package')
                                    ->relationship('thirdPackage', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('None'),
                                self::moneyInput('third_package_price_cents')
                                    ->label('Third Package Price'),
                                Select::make('sibling_package_id')
                                    ->label('Sibling Package')
                                    ->relationship('siblingPackage', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('None'),
                                self::moneyInput('sibling_package_price_cents')
                                    ->label('Sibling Package Price'),
                                self::moneyInput('sibling_special_fee_cents')
                                    ->label('Sibling Special Fee')
                    ->default(0),
                            ]),
                    ]),
                Section::make('Add-ons & Preferences')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                Toggle::make('four_poses_upgrade')
                                    ->label('Four Poses Upgrade')
                                    ->inline(false),
                                self::moneyInput('four_poses_upgrade_price_cents')
                                    ->label('Four Poses Price'),
                Toggle::make('pose_perfection')
                                    ->label('Pose Perfection')
                                    ->inline(false),
                                self::moneyInput('pose_perfection_price_cents')
                                    ->label('Pose Perfection Price'),
                Toggle::make('premium_retouch')
                                    ->label('Premium Retouch')
                                    ->inline(false),
                                self::moneyInput('premium_retouch_price_cents')
                                    ->label('Retouch Price'),
                                Textarea::make('retouch_specification')
                                    ->label('Retouch Notes')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('class_picture_size')
                                    ->label('Class Picture Size')
                                    ->maxLength(120),
                                self::moneyInput('class_picture_price_cents')
                                    ->label('Class Picture Price'),
                            ]),
                    ]),
                Section::make('Totals')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                self::moneyInput('subtotal_cents')
                                    ->label('Subtotal')
                    ->required(),
                                self::moneyInput('shipping_cents')
                                    ->label('Shipping')
                    ->default(0),
                                self::moneyInput('discount_cents')
                                    ->label('Discounts')
                    ->default(0),
                                TextInput::make('coupon_code')
                                    ->label('Coupon Code')
                                    ->maxLength(50),
                                self::moneyInput('total_cents')
                                    ->label('Total Due')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    protected static function moneyInput(string $field): TextInput
    {
        return TextInput::make($field)
            ->prefix('$')
                    ->numeric()
            ->minValue(0)
            ->step(0.01)
            ->formatStateUsing(fn (?int $state) => $state === null ? null : number_format($state / 100, 2, '.', ''))
            ->dehydrateStateUsing(fn ($state) => $state === null || $state === '' ? null : (int) round(((float) $state) * 100));
    }
}

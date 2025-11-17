<?php

namespace App\Filament\Resources\Schools\Schemas;

use App\Enums\OrganizationType;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('School Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                TextInput::make('name')
                                    ->label('School Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                                        if (blank($state) || filled($get('slug'))) {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    }),
                TextInput::make('slug')
                                    ->helperText('Used in URLs and shared links.')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Select::make('organization_type')
                                    ->label('Organization Type')
                                    ->options(collect(OrganizationType::cases())->mapWithKeys(fn ($type) => [$type->value => $type->label()]))
                                    ->default(OrganizationType::School->value)
                                    ->required(),
                                TextInput::make('organization_label')
                                    ->label('Display Label Override')
                                    ->helperText('Optional custom name shown to parents (e.g., Team, League, Company).'),
                                Toggle::make('is_active')
                                    ->inline(false)
                                    ->default(true)
                                    ->helperText('Inactive schools are hidden from registration flows.')
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Section::make('Organization Coordinators')
                    ->schema([
                        Select::make('coordinators')
                            ->relationship('coordinators', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Organization coordinators receive access to this group’s registrations, orders, and downloads.')
                            ->placeholder('Select coordinators')
                            ->columnSpanFull(),
                    ]),
                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('contact_name')
                                    ->label('Primary Contact')
                                    ->maxLength(255),
                TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->maxLength(255),
                TextInput::make('contact_phone')
                                    ->label('Contact Phone')
                                    ->tel()
                                    ->maxLength(25)
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Section::make('Location')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('address')
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                TextInput::make('city')
                                    ->maxLength(120),
                                TextInput::make('state')
                                    ->maxLength(2)
                                    ->placeholder('TX'),
                                TextInput::make('zip')
                                    ->label('ZIP Code')
                                    ->maxLength(10),
                            ]),
                    ]),
            ]);
    }
}

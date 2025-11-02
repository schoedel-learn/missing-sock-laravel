<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('school_id')
                                    ->label('School')
                                    ->relationship('school', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('name')
                    ->required()
                                    ->maxLength(255),
                TextInput::make('slug')
                                    ->helperText('Used in URLs and links shared with families.')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                TextInput::make('type')
                                    ->label('Session Type')
                                    ->placeholder('Fall Portraits, Spring Minis, ...')
                                    ->maxLength(120),
                                TagsInput::make('available_backdrops')
                                    ->label('Available Backdrops')
                                    ->placeholder('Add a backdrop and press enter')
                                    ->helperText('Used to power backdrop selection during pre-order.')
                    ->columnSpanFull(),
                Toggle::make('has_two_backdrops')
                                    ->inline(false)
                                    ->label('Two backdrop setup')
                                    ->default(false),
                DatePicker::make('registration_deadline')
                                    ->label('Registration Deadline')
                                    ->required()
                                    ->native(false),
                                DatePicker::make('session_date')
                                    ->label('Session Date')
                                    ->native(false),
                Toggle::make('is_active')
                                    ->inline(false)
                                    ->label('Active Project')
                                    ->default(true),
                            ]),
                    ]),
                Section::make('Notes')
                    ->schema([
                Textarea::make('notes')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Visible to staff only.'),
                    ]),
            ]);
    }
}

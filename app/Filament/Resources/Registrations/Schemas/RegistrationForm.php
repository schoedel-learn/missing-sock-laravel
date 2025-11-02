<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema;
use App\Models\Project;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registration Overview')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                TextInput::make('registration_number')
                                    ->label('Registration #')
                                    ->readOnly()
                                    ->helperText('Automatically generated when saved.')
                                    ->placeholder('Will be generated on save')
                                    ->columnSpan(1),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'confirmed' => 'Confirmed',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('registration_type')
                                    ->label('Registration Type')
                                    ->placeholder('Individual, Sibling, ...')
                                    ->maxLength(120)
                                    ->required()
                                    ->columnSpan(1),
                                Select::make('school_id')
                                    ->label('School')
                                    ->relationship('school', 'name')
                                    ->searchable()
                                    ->preload()
                    ->required()
                                    ->columnSpan(1),
                                Select::make('project_id')
                                    ->label('Project')
                                    ->options(fn (Get $get) => Project::query()
                                        ->when($get('school_id'), fn ($query) => $query->where('school_id', $get('school_id')))
                                        ->orderBy('registration_deadline', 'desc')
                                        ->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('number_of_children')
                                    ->label('Children')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),
                                Toggle::make('sibling_special')
                                    ->label('Sibling Special')
                                    ->helperText('Applies sibling special pricing if enabled.')
                                    ->inline(false),
                                Toggle::make('auto_select_images')
                                    ->label('Auto-select Images')
                                    ->inline(false)
                                    ->helperText('Photographer will choose best poses automatically.'),
                                Toggle::make('email_opt_in')
                                    ->label('Marketing Opt-in')
                                    ->inline(false),
                            ]),
                    ]),
                Section::make('Parent Contact')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                TextInput::make('parent_first_name')
                                    ->label('Parent First Name')
                                    ->required()
                                    ->maxLength(120),
                TextInput::make('parent_last_name')
                                    ->label('Parent Last Name')
                                    ->required()
                                    ->maxLength(120),
                TextInput::make('parent_email')
                                    ->label('Email')
                    ->email()
                                    ->required()
                                    ->maxLength(255),
                TextInput::make('parent_phone')
                                    ->label('Phone')
                    ->tel()
                    ->required()
                                    ->maxLength(25),
                            ]),
                    ]),
                Section::make('Shipping Preference')
                    ->schema([
                        Select::make('shipping_method')
                            ->options([
                                'school' => 'Deliver to school',
                                'home' => 'Ship to home',
                            ])
                    ->required()
                    ->default('school'),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('shipping_address')
                                    ->label('Address line 1')
                                    ->maxLength(255),
                                TextInput::make('shipping_address_line2')
                                    ->label('Address line 2')
                                    ->maxLength(255),
                                TextInput::make('shipping_city')
                                    ->label('City')
                                    ->maxLength(120),
                                TextInput::make('shipping_state')
                                    ->label('State')
                                    ->maxLength(2),
                                TextInput::make('shipping_zip')
                                    ->label('ZIP Code')
                                    ->maxLength(10),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                Section::make('Notes & Signatures')
                    ->schema([
                        TextInput::make('package_pose_distribution')
                            ->label('Package Pose Distribution')
                            ->maxLength(255),
                Textarea::make('special_instructions')
                            ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('signature_data')
                            ->label('Signature Data')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Captured at checkout; typically view-only.')
                            ->disabled(),
                        DateTimePicker::make('signature_date')
                            ->label('Signature Date')
                            ->seconds(false),
                    ]),
            ]);
    }
}

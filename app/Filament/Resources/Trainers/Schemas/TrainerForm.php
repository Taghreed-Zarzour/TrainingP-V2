<?php

namespace App\Filament\Resources\Trainers\Schemas;

use App\Enums\ImportantTopicsType;
use App\Enums\SexEnum;
use App\Models\Country;
use App\Models\ProvidedService;
use App\Models\WorkField;
use App\Models\WorkSector;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid as ComponentsGrid;



use Filament\Schemas\Schema;


class TrainerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('id')
                ->label('User')
                ->relationship('user', 'name')
                ->required(),

            ComponentsGrid::make(2)
                ->schema([
                    TextInput::make('last_name.en')
                        ->label('Last Name (English)'),
                    TextInput::make('last_name.ar')
                        ->label('Last Name (Arabic)')
                        ->required(),
                ]),

            Select::make('sex')
                ->options(SexEnum::class)
                ->required(),

            TextInput::make('headline')
                ->required(),

            Select::make('nationality')
                ->label('Nationalities')
                ->multiple()
                ->options(fn () => Country::pluck('name_ar', 'id')->toArray())
                ->columnSpanFull()
                ->required()
                ->saveRelationshipsUsing(function ($state) {
                    return implode(',', $state);
                }),

            Select::make('work_sectors')
                ->label('Work Sectors')
                ->multiple()
                ->options(fn () => WorkSector::pluck('name', 'id')->toArray())
                ->columnSpanFull()
                ->required()
                ->saveRelationshipsUsing(function ($state) {
                    return implode(',', $state);
                }),

            Select::make('provided_services')
                ->label('Provided Services')
                ->multiple()
                ->options(fn () => ProvidedService::pluck('name', 'id')->toArray())
                ->columnSpanFull()
                ->required()
                ->saveRelationshipsUsing(function ($state) {
                    return implode(',', $state);
                }),

            Select::make('work_fields')
                ->label('Work Fields')
                ->multiple()
                ->options(fn () => WorkField::pluck('name', 'id')->toArray())
                ->columnSpanFull()
                ->required()
                ->saveRelationshipsUsing(function ($state) {
                    return implode(',', $state);
                }),

            Textarea::make('international_exp')
                ->default(null)
                ->columnSpanFull(),

            TextInput::make('linkedin_url')
                ->default(null),

            TextInput::make('website')
                ->default(null),

            select::make('important_topics')
                ->default(null)
                ->multiple()
                ->options(
                    collect(ImportantTopicsType::cases())
                        ->mapWithKeys(fn($case) => [$case->value => $case->name])
                        ->toArray()
                ),


            TextInput::make('hourly_wage')
                ->numeric()
                ->default(null),

            TextInput::make('currency')
                ->default(null),
        ]);

    }
}

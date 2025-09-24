<?php

namespace App\Filament\Resources\Assistants\Schemas;

use App\Enums\SexEnum;
use App\Models\Country;
use App\Models\ExperienceArea;
use App\Models\Language;
use App\Models\ProvidedService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid as ComponentsGrid;

use function Ramsey\Uuid\v1;

class AssistantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->label('Sex')
                    ->options(SexEnum::class)
                    ->required(),

                TextInput::make('headline')
                    ->label('Headline')
                    ->required(),

                Select::make('nationality')
                    ->label('Nationalities')
                    ->multiple()
                    ->options(fn () => Country::pluck('name', 'id')->toArray())
                    ->columnSpanFull()
                    ->required()
                    ->saveRelationshipsUsing(function ($state) {
                        return implode(',', $state);
                    }),

                TextInput::make('years_of_experience')
                    ->label('Years of Experience')
                    ->required()
                    ->numeric(),

                Select::make('experience_areas')
                    ->label('Experience Areas')
                    ->multiple()
                    ->options(fn () => ExperienceArea::pluck('name', 'id')->toArray())
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

                TextInput::make('specialization')
                    ->label('Specialization')
                    ->required(),

                TextInput::make('university')
                    ->label('University')
                    ->required(),

                DatePicker::make('graduation_year')
                    ->label('Graduation Year')
                    ->required(),

                Select::make('education_levels_id')
                    ->label('Education Level')
                    ->relationship('educationLevel', 'name')
                    ->required(),

                Select::make('languages')
                    ->label('Languages')
                    ->multiple()
                    ->options(fn () => Language::pluck('name', 'id')->toArray())
                    ->columnSpanFull()
                    ->required()
                    ->saveRelationshipsUsing(function ($state) {
                        return implode(',', $state);
                    }),
            ]);

    }
}

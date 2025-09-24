<?php

namespace App\Filament\Resources\OrgTrainingPrograms\Schemas;

use App\Enums\TrainingAttendanceType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Organization;
use App\Models\programType;
use App\Models\TrainingClassification;
use App\Models\trainingLevel;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrgTrainingProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->label('Organization')
                    ->required()
                    ->options(User::where('user_type_id', 4)->pluck('name', 'id'))
                    ->searchable(),

                Textarea::make('title')
                    ->required()
                    ->columnSpanFull(),

                Select::make('language_id')
                    ->label('Language')
                    ->options(Language::pluck('name', 'id')->toArray())
                    ->required()
                    ->columnSpanFull(),

                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::pluck('name', 'id')->toArray())
                    ->reactive()
                    ->required(),

                    Select::make('city')
                    ->label('city')
                    ->options(function (callable $get) {
                        $countryId = $get('country_id');
                        if (! $countryId) {
                            return [];
                        }
                        $cities = collect(json_decode(file_get_contents(public_path('assets/states.json')), true));

                        return $cities
                            ->where('country_id', $countryId)
                            ->pluck('name', 'name')
                            ->toArray();
                    })
                    ->reactive()
                    ->required(),

                Textarea::make('address_in_detail')
                    ->label('Address in Detail')
                    ->columnSpanFull(),

                Select::make('programType')
                    ->relationship('programType', 'name')
                    ->required(),

                Select::make('training_level_id')
                    ->label('Training Level')
                    ->options(trainingLevel::pluck('name', 'id')->toArray())
                    ->required(),

                Select::make('program_presentation_method')
                    ->label('Presentation Method')
                    ->options(
                        collect(TrainingAttendanceType::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->name])
                            ->toArray()
                    )
                    ->native(false)
                    ->required(),

                Select::make('org_training_classification_id')
                    ->label('Training Classifications')
                    ->options(TrainingClassification::orderBy('name')->pluck('name', 'id')->toArray())
                    ->multiple()
                    ->searchable()
                    ->required()
                    ->placeholder('Select classifications'),

                Textarea::make('program_description')
                    ->label('Program Description')
                    ->columnSpanFull(),

                Toggle::make('is_edit_mode')
                    ->label('Edit Mode')
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => $state ? 1 : 0),

                Select::make('status')
                    ->label('Status')
                    ->options(['online' => 'Online', 'offline' => 'Offline'])
                    ->default('online')
                    ->required(),
            ]);

    }
}

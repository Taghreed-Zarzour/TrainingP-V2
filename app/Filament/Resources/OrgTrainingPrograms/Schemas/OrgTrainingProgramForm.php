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
                    ->options(fn () => Language::pluck('name', 'id')->toArray())
                    ->columnSpanFull()
                    ->required(),
                Select::make('country_id')
                    ->label('country')
                    ->options(
                        Country::pluck('name_ar', 'id')->toArray()
                    )
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
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('program_type_id')
                    ->label('Program Type')
                    ->options(programType::all()->pluck('name', 'id')->toArray())
                    ->required(),
                Select::make('training_level_id')
                    ->label('Training Level')
                    ->options(trainingLevel::all()->pluck('name', 'id')->toArray())
                    ->required(),
                    Select::make('program_presentation_method_id')
                    ->label('Presentation Method')
                    ->options(collect(TrainingAttendanceType::cases())
                        ->mapWithKeys(fn ($case) => [$case->name => $case->value])
                        ->toArray()
                    )
                    ->native(false)

                    ->required(),
                    Select::make('training_classification_id')
                    ->label('Training Classification')
                    ->options(
                        TrainingClassification::orderBy('name')->pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->multiple()
                    ->placeholder('Select a classification')
                    ->required(),

                Textarea::make('program_description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_edit_mode')
                    ->required(),
                Select::make('status')
                    ->options(['online' => 'Online', 'offline' => 'Offline'])
                    ->default('online')
                    ->required(),
            ]);
    }
}

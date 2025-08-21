<?php

namespace App\Filament\Resources\TrainingPrograms\Schemas;

use App\Enums\TrainingAttendanceType;
use App\Models\Language;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

use App\Models\ProgramType;
use App\Models\TrainingClassification;
use App\Models\TrainingLevel;
use App\Models\User;


class TrainingProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('title')
                ->label('Program Title')
                ->required()
                ->columnSpanFull(),

            TextInput::make('description')
                ->label('Description')
                ->default(null),

            TextInput::make('views')
                ->label('Views')
                ->required()
                ->numeric()
                ->disabled()
                ->default(0),

            Select::make('program_type_id')
                ->label('Program Type')
                ->options(ProgramType::all()->pluck('name', 'id')->toArray())
                ->required(),

            Select::make('language_type_id')
                ->label('Language')
                ->options(Language::all()->pluck('name', 'id')->toArray())
                ->required(),

            Select::make('training_classification_id')
                ->label('Training Classification')
                ->options(TrainingClassification::all()->pluck('name', 'id')->toArray())
                ->required(),

            Select::make('training_level_id')
                ->label('Training Level')
                ->options(TrainingLevel::all()->pluck('name', 'id')->toArray())
                ->required(),

            Select::make('program_presentation_method_id')
                ->label('Presentation Method')
                ->options(collect(TrainingAttendanceType::cases())
                    ->mapWithKeys(fn ($case) => [$case->name => $case->value])
                    ->toArray()
                )
                ->native(false)

                ->required(),


            Toggle::make('schedules_later')
                ->label('Schedule Later')
                ->required(),

            Select::make('user_id')
                ->label('Trainer')
                ->options(User::all()->pluck('name', 'id')->toArray())
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'online' => 'Online',
                    'stopped' => 'Stopped',
                ])
                ->default('online')
                ->required(),
        ]);
    }




}

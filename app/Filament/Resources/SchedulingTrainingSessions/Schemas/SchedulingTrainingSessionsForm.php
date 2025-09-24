<?php

namespace App\Filament\Resources\SchedulingTrainingSessions\Schemas;

use App\Models\TrainingProgram;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;


class SchedulingTrainingSessionsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                select::make('training_program_id')
                    ->required()
                    ->options(
                        TrainingProgram::all()->pluck('title', 'id')
                    ),
                DatePicker::make('session_date')
                    ->required(),
                TimePicker::make('session_start_time')
                    ->required(),
                TimePicker::make('session_end_time')
                    ->required(),
            ]);
    }
}

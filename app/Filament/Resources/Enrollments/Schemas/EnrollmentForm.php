<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('trainee_id')
                    ->label('Trainee')
                    ->relationship('trainee.user', 'name')
                    ->searchable()
                    ->required(),

                Select::make('training_programs_id')
                    ->label('Training Program')
                    ->relationship('trainingProgram', 'title')
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),

                DateTimePicker::make('registered_at')
                    ->label('Registered At')
                    ->required(),

                TextInput::make('rejection_reason')
                    ->label('Rejection Reason')
                    ->nullable(),
            ]);

    }
}

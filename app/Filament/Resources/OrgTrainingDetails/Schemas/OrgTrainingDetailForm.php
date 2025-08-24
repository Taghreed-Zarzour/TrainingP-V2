<?php

namespace App\Filament\Resources\OrgTrainingDetails\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrgTrainingDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components([
            TextInput::make('org_training_program_id')
                ->required()
                ->numeric(),

            Textarea::make('program_title')
                ->required()
                ->columnSpanFull(),

            Select::make('trainer_id')
                ->relationship('trainer', 'name')
                ->preload()
                ->searchable()
                ->required(),

            Toggle::make('schedule_later')
                ->required(),

            TextInput::make('num_of_session')
                ->numeric()
                ->default(null),

            TextInput::make('num_of_hours')
                ->numeric()
                ->default(null),

                FileUpload::make('training_files')
                ->multiple()
                ->disk('public')
                ->directory('training-files')
                ->preserveFilenames()
                ->columnSpanFull()
                ->label('Training Files'),
        ]);

    }
}

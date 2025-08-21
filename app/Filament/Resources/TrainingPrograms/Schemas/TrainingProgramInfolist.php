<?php

namespace App\Filament\Resources\TrainingPrograms\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TrainingProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description'),
                TextEntry::make('views')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('programType.name')
                    ->label('program type')
                    ->numeric(),
                TextEntry::make('language.name')
                    ->label('program language')
                    ->numeric(),
                TextEntry::make('trainingClassification.name')
                    ->label('training classification')
                    ->numeric(),
                TextEntry::make('trainingLevel.name')
                    ->label('training level')
                    ->numeric(),
                TextEntry::make('program_presentation_method_id')
                    ->label('program presentation method'),
                IconEntry::make('schedules_later')
                    ->boolean(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('status'),
            ]);
    }
}

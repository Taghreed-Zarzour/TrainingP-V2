<?php

namespace App\Filament\Resources\SchedulingTrainingSessions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SchedulingTrainingSessionsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trainingProgram.title')
                    ->label('program title')
                    ->numeric(),
                TextEntry::make('session_date')
                    ->date(),
                TextEntry::make('session_start_time')
                    ->time(),
                TextEntry::make('session_end_time')
                    ->time(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

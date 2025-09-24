<?php

namespace App\Filament\Resources\OrgTrainingDetails\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrgTrainingDetailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('program_title')
                    ->numeric(),
                TextEntry::make('trainer.name')
                    ->numeric(),
                IconEntry::make('schedule_later')
                    ->boolean(),
                TextEntry::make('num_of_session')
                    ->numeric(),
                TextEntry::make('num_of_hours')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\OrgTrainingPrograms\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrgTrainingProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('organization_id')
                    ->numeric(),
                TextEntry::make('language_id')
                    ->numeric(),
                TextEntry::make('country_id')
                    ->numeric(),
                TextEntry::make('city'),
                TextEntry::make('program_type'),
                TextEntry::make('training_level_id')
                    ->numeric(),
                TextEntry::make('program_presentation_method'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                IconEntry::make('is_edit_mode')
                    ->boolean(),
                TextEntry::make('status'),
            ]);
    }
}

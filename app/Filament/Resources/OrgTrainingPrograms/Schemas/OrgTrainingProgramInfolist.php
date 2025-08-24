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
                TextEntry::make('organization.user.name')
                    ->label('organization name')
                    ->numeric(),
                TextEntry::make('title'),
                TextEntry::make('language.name')
                    ->label('language')
                    ->numeric(),
                TextEntry::make('country.name')
                    ->label('country')
                    ->numeric(),
                TextEntry::make('city'),
                TextEntry::make('address_in_detail'),
                TextEntry::make('programType.name')
                    ->label('program type'),
                TextEntry::make('trainingLevel.name')
                    ->label('training level')
                    ->numeric(),
                TextEntry::make('program_presentation_method'),

                TextEntry::make('org_training_classification_id')
                ->label('Training Classifications')
                ->getStateUsing(function ($record) {
                    $ids = $record->org_training_classification_id; // Already an array

                    return \App\Models\TrainingClassification::whereIn('id', $ids)
                        ->pluck('name')
                        ->implode(', ');
                }),
                TextEntry::make('program_description'),
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

<?php

namespace App\Filament\Resources\Trainees\Schemas;

use App\Models\WorkField;
use App\Models\WorkSector;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TraineeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),

                TextEntry::make('last_name')
                    ->label('Last Name')
                    ->formatStateUsing(fn($state, $record) =>
                        $record->getTranslation('last_name', 'en') . ' / ' . $record->getTranslation('last_name', 'ar')
                    ),

                TextEntry::make('sex'),

                TextEntry::make('work_fields')
                    ->label('Work Fields')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return WorkField::whereIn('id', $ids)->pluck('name')->implode(', ');
                    }),

                TextEntry::make('work_sectors')
                    ->label('Work Sectors')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return $ids->isEmpty()
                            ? '—'
                            : WorkSector::whereIn('id', $ids)->pluck('name')->implode(', ');
                    }),

                TextEntry::make('extra_work_field')
                    ->label('Extra Work Field'),

                TextEntry::make('educationLevel.name')
                    ->label('Education Level'),

                TextEntry::make('fields_of_interest')
                    ->label('Fields of Interest')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),

                IconEntry::make('is_working')
                    ->boolean(),

                TextEntry::make('job_position'),

                TextEntry::make('training_attendance'),

                TextEntry::make('work_institution'),

                TextEntry::make('preferred_times')
                    ->label('Preferred Times')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);

    }
}

<?php

namespace App\Filament\Resources\Trainers\Schemas;

use App\Models\ProvidedService;
use App\Models\WorkField;
use App\Models\WorkSector;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TrainerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextEntry::make('last_name')
                    ->label('Last Name')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->getTranslation('last_name', 'en') . ' / ' . $record->getTranslation('last_name', 'ar');
                    }),

            TextEntry::make('sex'),

            TextEntry::make('headline'),

            TextEntry::make('work_sectors')
                ->label('Work Sectors')
                ->formatStateUsing(function ($state) {
                    $ids = collect(explode(',', $state))
                        ->map(fn($id) => (int) trim($id))
                        ->filter();

                    return WorkSector::whereIn('id', $ids)->pluck('name')->implode(', ');
                }),

            TextEntry::make('provided_services')
                ->label('Provided Services')
                ->formatStateUsing(function ($state) {
                    $ids = collect(explode(',', $state))
                        ->map(fn($id) => (int) trim($id))
                        ->filter();

                    return ProvidedService::whereIn('id', $ids)->pluck('name')->implode(', ');
                }),

            TextEntry::make('work_fields')
                ->label('Work Fields')
                ->formatStateUsing(function ($state) {
                    $ids = collect(explode(',', $state))
                        ->map(fn($id) => (int) trim($id))
                        ->filter();

                    return WorkField::whereIn('id', $ids)->pluck('name')->implode(', ');
                }),

            TextEntry::make('important_topics')
                ->label('Important Topics')
                ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),

            TextEntry::make('international_exp')
                ->label('International Experience')
                ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),

            TextEntry::make('linkedin_url')
                ->label('LinkedIn')
                ->url(fn($state) => $state)
                ->openUrlInNewTab(),


            TextEntry::make('website')
                ->label('Website')
                ->url(fn($state) => $state)
                ->openUrlInNewTab(),


            TextEntry::make('hourly_wage')
                ->numeric(),

            TextEntry::make('currency'),

            TextEntry::make('created_at')
                ->dateTime(),

            TextEntry::make('updated_at')
                ->dateTime(),
        ]);


    }
}

<?php

namespace App\Filament\Resources\Assistants\Schemas;

use App\Models\ExperienceArea;
use App\Models\Language;
use App\Models\ProvidedService;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssistantInfolist
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

                TextEntry::make('headline'),

                TextEntry::make('years_of_experience')
                    ->numeric(),

                TextEntry::make('experience_areas')
                    ->label('Experience Areas')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return $ids->isEmpty()
                            ? '—'
                            : ExperienceArea::whereIn('id', $ids)->pluck('name')->implode(', ');
                    }),

                TextEntry::make('provided_services')
                    ->label('Provided Services')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return ProvidedService::whereIn('id', $ids)->pluck('name')->implode(', ');
                    }),

                TextEntry::make('specialization'),

                TextEntry::make('university'),

                TextEntry::make('graduation_year')
                    ->date(),

                TextEntry::make('educationLevel.name')
                    ->label('Education Level'),

                TextEntry::make('languages')
                    ->label('Languages')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return Language::whereIn('id', $ids)->pluck('name')->implode(', ');
                    }),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);

    }
}

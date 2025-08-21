<?php

namespace App\Filament\Resources\Trainers\Tables;

use App\Models\Country;
use App\Models\ProvidedService;
use App\Models\WorkField;
use App\Models\WorkSector;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),

                TextColumn::make('last_name')
                    ->label('Last Name')
                    ->formatStateUsing(fn($state, $record) =>
                        $record->getTranslation('last_name', 'en') . ' / ' . $record->getTranslation('last_name', 'ar')
                    )
                    ->searchable(),
                TextColumn::make('sex')
                    ->searchable(),
                TextColumn::make('headline')
                    ->searchable(),
                TextColumn::make('user.nationalities')
                    ->label('Nationalities')
                    ->formatStateUsing(function ($state, $record) {
                        $countries = $record->user?->nationalities;

                        if ($countries && $countries->count()) {
                            return $countries->pluck('name')->implode(', ');
                        }

                        return '—';
                    }),

                TextColumn::make('work_sectors')
                    ->label('Work Sectors')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();
                        if ($ids->isEmpty()) {
                            return '—';
                        }
                        return WorkSector::whereIn('id', $ids)->pluck('name')->implode(', ');
                    })
                    ->toggleable(),

                TextColumn::make('provided_services')
                    ->label('Provided Services')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return ProvidedService::whereIn('id', $ids)->pluck('name')->implode(', ');
                    })
                    ->toggleable(),

                TextColumn::make('work_fields')
                    ->label('Work Fields')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return WorkField::whereIn('id', $ids)->pluck('name')->implode(', ');
                    })
                    ->toggleable(),

                TextColumn::make('important_topics')
                    ->label('Important Topics')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->toggleable(),

                    TextColumn::make('international_exp')
                    ->label('International Experience')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->toggleable(),

                TextColumn::make('linkedin_url')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('website')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('hourly_wage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

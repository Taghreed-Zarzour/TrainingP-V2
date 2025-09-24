<?php

namespace App\Filament\Resources\Assistants\Tables;

use App\Models\ExperienceArea;
use App\Models\Language;
use App\Models\ProvidedService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssistantsTable
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
                TextColumn::make('years_of_experience')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('experience_areas')
                    ->label('Experience Areas')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();
                        if ($ids->isEmpty()) {
                            return '—';
                        }
                        return ExperienceArea::whereIn('id', $ids)->pluck('name')->implode(', ');
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
                TextColumn::make('specialization')
                    ->searchable(),
                TextColumn::make('university')
                    ->searchable(),
                TextColumn::make('graduation_year')
                    ->date()
                    ->sortable(),
                TextColumn::make('educationLevel.name')
                    ->sortable(),
                TextColumn::make('languages')
                    ->label('languages')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return Language::whereIn('id', $ids)->pluck('name')->implode(', ');
                    })
                    ->toggleable(),
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

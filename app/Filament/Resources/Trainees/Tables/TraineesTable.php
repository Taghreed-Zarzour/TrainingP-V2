<?php

namespace App\Filament\Resources\Trainees\Tables;

use App\Models\WorkField;
use App\Models\WorkSector;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TraineesTable
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
                TextColumn::make('work_fields')
                    ->label('Work Fields')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return WorkField::whereIn('id', $ids)->pluck('name')->implode(', ');
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
                TextColumn::make('extra_work_field')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('educationLevel.name')
                    ->sortable(),
                TextColumn::make('fields_of_interest')
                    ->label('fields of interest')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
                IconColumn::make('is_working')
                    ->boolean(),
                TextColumn::make('job_position')
                    ->searchable(),
                TextColumn::make('training_attendance')
                    ->searchable(),
                TextColumn::make('work_institution')
                    ->searchable(),

                TextColumn::make('preferred_times')
                    ->label('preferred_times')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->toggleable(isToggledHiddenByDefault: true),
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

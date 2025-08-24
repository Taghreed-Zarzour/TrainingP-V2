<?php

namespace App\Filament\Resources\OrgTrainingDetails\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrgTrainingDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('program_title')
            ->label('Program Title'),
            TextColumn::make('trainer.name')
            ->label('Trainer'),
            TextColumn::make('num_of_session')
            ->label('Sessions'),
            TextColumn::make('num_of_hours')
            ->label('Hours'),
            TagsColumn::make('training_files')
            ->label('Training Files')
            ->getStateUsing(function ($record) {
                $raw = $record->training_files;

                // Decode JSON string if necessary
                $files = is_string($raw) ? json_decode($raw, true) : $raw;

                // Handle decoding failure
                if (!is_array($files)) {
                    return ['Invalid file format'];
                }

                // Extract filenames
                return collect($files)
                    ->map(fn($path) => basename(str_replace('\\', '/', $path)))
                    ->toArray();
            }),

            IconColumn::make('schedule_later')
            ->label('Scheduled Later')
            ->icon(fn ($state) => $state ? 'heroicon-o-clock' : 'heroicon-o-x-circle')
            ->color(fn ($state) => $state ? 'warning' : 'gray')
            ->tooltip(fn ($state) => $state ? 'Scheduled for later' : 'Not scheduled'),

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

<?php

namespace App\Filament\Resources\TrainerRatings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainerRatingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainee.user.name')
                    ->label('trainee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('trainer.user.name')
                    ->label('trainer')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('comment')
                    ->sortable(),
                TextColumn::make('clarity')
                    ->label('Clarity')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        $stars = str_repeat('⭐', (int) $state);
                        return "<span>{$stars}</span>";
                    }),
                TextColumn::make('interaction')
                    ->label('Interaction')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        $stars = str_repeat('⭐', (int) $state);
                        return "<span>{$stars}</span>";
                    }),
                TextColumn::make('organization')
                    ->label('Organization')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        $stars = str_repeat('⭐', (int) $state);
                        return "<span>{$stars}</span>";
                    }),

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

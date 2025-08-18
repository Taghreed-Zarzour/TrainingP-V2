<?php

namespace App\Filament\Resources\UserCvs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserCvsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cv_file')
                    ->label('السيرة الذاتية')
                    ->formatStateUsing(function ($state, $record) {
                        $url = route('admin.download.cv', ['user' => $record->user_id]);

                        return <<<HTML
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #374151;">{$state}</span>
                                <a href="{$url}"
                                style="background-color: #2563eb; color: white; padding: 4px 8px; border-radius: 6px; font-size: 12px; text-decoration: none;"
                                download>
                                    تحميل
                                </a>
                            </div>
                        HTML;
                    })
                    ->html(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
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

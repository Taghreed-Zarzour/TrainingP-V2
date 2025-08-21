<?php

namespace App\Filament\Resources\Organizations\Tables;

use App\Models\Country;
use App\Models\OrganizationSector;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('type.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('website')
                    ->searchable(),
                TextColumn::make('employeeNumber.range')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('established_year'),
                TextColumn::make('annualBudget.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('organization_sectors')
                    ->label('Organization Sectors')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();
                        if ($ids->isEmpty()) {
                            return '—';
                        }
                        return OrganizationSector::whereIn('id', $ids)->pluck('name')->implode(', ');
                    })
                    ->toggleable(),
                TextColumn::make('branches')
                    ->label('Branches')
                    ->formatStateUsing(function ($state) {
                        $branch = is_string($state) ? json_decode($state, true) : $state;
                        if (!is_array($branch) || !isset($branch['country_id'], $branch['city'])) {
                            return '—';
                        }
                        $countryName = Country::find((int) $branch['country_id'])?->name_ar ?? 'Unknown';
                        $city = $branch['city'] ?? 'Unknown';

                        return "{$city}, {$countryName}";
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

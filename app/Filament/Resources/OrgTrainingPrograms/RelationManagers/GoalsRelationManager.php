<?php

namespace App\Filament\Resources\OrgTrainingPrograms\RelationManagers;

use App\Filament\Resources\OrgTrainingPrograms\OrgTrainingProgramResource;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\WorkSector;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class GoalsRelationManager extends RelationManager
{
    protected static string $relationship = 'goals';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_position'),
                TextColumn::make('learning_outcomes')
                ->label('learning outcomes'),
                TextColumn::make('education_level_id')
                ->label('Education Levels')
                ->formatStateUsing(function ($state) {
                    if (is_string($state)) {
                        $state = explode(',', $state);
                    }
                    $names = EducationLevel::whereIn('id', $state)->pluck('name')->toArray();
                    return count($names) ? implode(', ', $names) : '—';
                }),

                TextColumn::make('work_sector_id')
                ->label('Work Sectors')
                ->formatStateUsing(function ($state) {
                    if (is_string($state)) {
                        $state = explode(',', $state);
                    }
                    $names = WorkSector::whereIn('id', $state)->pluck('name')->toArray();
                    return count($names) ? implode(', ', $names) : '—';
                }),

                TextColumn::make('work_status')
                ->label('Work Status'),

                TextColumn::make('country_id')
                ->label('Countries')
                ->formatStateUsing(function ($state) {
                    if (is_string($state)) {
                        $state = explode(',', $state);
                    }
                    $names = Country::whereIn('id', $state)->pluck('name')->toArray();
                    return count($names) ? implode(', ', $names) : '—';
                }),

            ])

            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

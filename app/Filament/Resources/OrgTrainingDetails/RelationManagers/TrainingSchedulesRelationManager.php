<?php

namespace App\Filament\Resources\OrgTrainingDetails\RelationManagers;

use App\Filament\Resources\OrgTrainingDetails\OrgTrainingDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingSchedules';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('session_date')->label('Session Date')->date(),
                TextColumn::make('session_start_time')->label('Start Time'),
                TextColumn::make('session_end_time')->label('End Time'),
            ])

            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

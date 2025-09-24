<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use App\Filament\Resources\SchedulingTrainingSessions\SchedulingTrainingSessionsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sessions';

    protected static ?string $relatedResource = SchedulingTrainingSessionsResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

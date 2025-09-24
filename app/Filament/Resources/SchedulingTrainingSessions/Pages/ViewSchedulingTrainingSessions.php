<?php

namespace App\Filament\Resources\SchedulingTrainingSessions\Pages;

use App\Filament\Resources\SchedulingTrainingSessions\SchedulingTrainingSessionsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSchedulingTrainingSessions extends ViewRecord
{
    protected static string $resource = SchedulingTrainingSessionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

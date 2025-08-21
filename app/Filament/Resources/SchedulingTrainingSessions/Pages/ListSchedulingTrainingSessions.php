<?php

namespace App\Filament\Resources\SchedulingTrainingSessions\Pages;

use App\Filament\Resources\SchedulingTrainingSessions\SchedulingTrainingSessionsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchedulingTrainingSessions extends ListRecords
{
    protected static string $resource = SchedulingTrainingSessionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

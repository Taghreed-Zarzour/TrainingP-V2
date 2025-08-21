<?php

namespace App\Filament\Resources\SchedulingTrainingSessions\Pages;

use App\Filament\Resources\SchedulingTrainingSessions\SchedulingTrainingSessionsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSchedulingTrainingSessions extends EditRecord
{
    protected static string $resource = SchedulingTrainingSessionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

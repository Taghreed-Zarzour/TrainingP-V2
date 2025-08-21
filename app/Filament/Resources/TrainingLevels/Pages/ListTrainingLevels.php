<?php

namespace App\Filament\Resources\TrainingLevels\Pages;

use App\Filament\Resources\TrainingLevels\TrainingLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingLevels extends ListRecords
{
    protected static string $resource = TrainingLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

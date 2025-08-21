<?php

namespace App\Filament\Resources\TrainingClassifications\Pages;

use App\Filament\Resources\TrainingClassifications\TrainingClassificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingClassifications extends ListRecords
{
    protected static string $resource = TrainingClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

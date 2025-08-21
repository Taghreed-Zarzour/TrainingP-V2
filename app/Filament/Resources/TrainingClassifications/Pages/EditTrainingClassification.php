<?php

namespace App\Filament\Resources\TrainingClassifications\Pages;

use App\Filament\Resources\TrainingClassifications\TrainingClassificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingClassification extends EditRecord
{
    protected static string $resource = TrainingClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\TrainingLevels\Pages;

use App\Filament\Resources\TrainingLevels\TrainingLevelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingLevel extends EditRecord
{
    protected static string $resource = TrainingLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

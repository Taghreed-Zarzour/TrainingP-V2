<?php

namespace App\Filament\Resources\TrainingPrograms\Pages;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingProgram extends EditRecord
{
    protected static string $resource = TrainingProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

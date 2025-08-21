<?php

namespace App\Filament\Resources\OrgTrainingPrograms\Pages;

use App\Filament\Resources\OrgTrainingPrograms\OrgTrainingProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrgTrainingProgram extends EditRecord
{
    protected static string $resource = OrgTrainingProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

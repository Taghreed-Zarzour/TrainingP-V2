<?php

namespace App\Filament\Resources\OrgTrainingPrograms\Pages;

use App\Filament\Resources\OrgTrainingPrograms\OrgTrainingProgramResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrgTrainingProgram extends ViewRecord
{
    protected static string $resource = OrgTrainingProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

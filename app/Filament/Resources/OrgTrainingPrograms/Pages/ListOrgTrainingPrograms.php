<?php

namespace App\Filament\Resources\OrgTrainingPrograms\Pages;

use App\Filament\Resources\OrgTrainingPrograms\OrgTrainingProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrgTrainingPrograms extends ListRecords
{
    protected static string $resource = OrgTrainingProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

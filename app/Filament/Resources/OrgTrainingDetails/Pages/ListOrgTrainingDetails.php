<?php

namespace App\Filament\Resources\OrgTrainingDetails\Pages;

use App\Filament\Resources\OrgTrainingDetails\OrgTrainingDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrgTrainingDetails extends ListRecords
{
    protected static string $resource = OrgTrainingDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

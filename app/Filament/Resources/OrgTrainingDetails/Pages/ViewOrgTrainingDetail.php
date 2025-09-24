<?php

namespace App\Filament\Resources\OrgTrainingDetails\Pages;

use App\Filament\Resources\OrgTrainingDetails\OrgTrainingDetailResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrgTrainingDetail extends ViewRecord
{
    protected static string $resource = OrgTrainingDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

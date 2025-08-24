<?php

namespace App\Filament\Resources\OrgTrainingDetails\Pages;

use App\Filament\Resources\OrgTrainingDetails\OrgTrainingDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrgTrainingDetail extends EditRecord
{
    protected static string $resource = OrgTrainingDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

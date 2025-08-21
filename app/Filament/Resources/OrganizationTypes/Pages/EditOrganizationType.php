<?php

namespace App\Filament\Resources\OrganizationTypes\Pages;

use App\Filament\Resources\OrganizationTypes\OrganizationTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationType extends EditRecord
{
    protected static string $resource = OrganizationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

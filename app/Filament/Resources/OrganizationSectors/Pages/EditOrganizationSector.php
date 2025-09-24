<?php

namespace App\Filament\Resources\OrganizationSectors\Pages;

use App\Filament\Resources\OrganizationSectors\OrganizationSectorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationSector extends EditRecord
{
    protected static string $resource = OrganizationSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

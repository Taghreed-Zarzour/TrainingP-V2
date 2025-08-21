<?php

namespace App\Filament\Resources\OrganizationSectors\Pages;

use App\Filament\Resources\OrganizationSectors\OrganizationSectorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationSectors extends ListRecords
{
    protected static string $resource = OrganizationSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\WorkSectors\Pages;

use App\Filament\Resources\WorkSectors\WorkSectorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkSectors extends ListRecords
{
    protected static string $resource = WorkSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

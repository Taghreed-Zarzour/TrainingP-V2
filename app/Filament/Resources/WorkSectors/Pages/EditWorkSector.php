<?php

namespace App\Filament\Resources\WorkSectors\Pages;

use App\Filament\Resources\WorkSectors\WorkSectorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkSector extends EditRecord
{
    protected static string $resource = WorkSectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

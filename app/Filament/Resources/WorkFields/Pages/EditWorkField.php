<?php

namespace App\Filament\Resources\WorkFields\Pages;

use App\Filament\Resources\WorkFields\WorkFieldResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkField extends EditRecord
{
    protected static string $resource = WorkFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

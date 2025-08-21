<?php

namespace App\Filament\Resources\ProvidedServices\Pages;

use App\Filament\Resources\ProvidedServices\ProvidedServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProvidedService extends EditRecord
{
    protected static string $resource = ProvidedServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

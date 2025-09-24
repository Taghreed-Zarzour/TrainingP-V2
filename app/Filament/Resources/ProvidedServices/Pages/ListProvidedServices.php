<?php

namespace App\Filament\Resources\ProvidedServices\Pages;

use App\Filament\Resources\ProvidedServices\ProvidedServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProvidedServices extends ListRecords
{
    protected static string $resource = ProvidedServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\WorkFields\Pages;

use App\Filament\Resources\WorkFields\WorkFieldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkFields extends ListRecords
{
    protected static string $resource = WorkFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

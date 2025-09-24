<?php

namespace App\Filament\Resources\EmployeeNumbers\Pages;

use App\Filament\Resources\EmployeeNumbers\EmployeeNumberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeNumbers extends ListRecords
{
    protected static string $resource = EmployeeNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

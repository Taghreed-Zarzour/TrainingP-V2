<?php

namespace App\Filament\Resources\EmployeeNumbers\Pages;

use App\Filament\Resources\EmployeeNumbers\EmployeeNumberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeNumber extends EditRecord
{
    protected static string $resource = EmployeeNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

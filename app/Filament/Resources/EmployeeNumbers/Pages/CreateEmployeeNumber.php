<?php

namespace App\Filament\Resources\EmployeeNumbers\Pages;

use App\Filament\Resources\EmployeeNumbers\EmployeeNumberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeNumber extends CreateRecord
{
    protected static string $resource = EmployeeNumberResource::class;
}

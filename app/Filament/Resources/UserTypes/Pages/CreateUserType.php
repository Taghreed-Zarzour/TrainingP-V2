<?php

namespace App\Filament\Resources\UserTypes\Pages;

use App\Filament\Resources\UserTypes\UserTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserType extends CreateRecord
{
    protected static string $resource = UserTypeResource::class;
}

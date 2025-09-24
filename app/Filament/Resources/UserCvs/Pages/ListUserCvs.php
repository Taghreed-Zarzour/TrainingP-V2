<?php

namespace App\Filament\Resources\UserCvs\Pages;

use App\Filament\Resources\UserCvs\UserCvResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserCvs extends ListRecords
{
    protected static string $resource = UserCvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

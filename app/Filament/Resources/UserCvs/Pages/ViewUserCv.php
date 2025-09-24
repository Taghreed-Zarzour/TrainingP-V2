<?php

namespace App\Filament\Resources\UserCvs\Pages;

use App\Filament\Resources\UserCvs\UserCvResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserCv extends ViewRecord
{
    protected static string $resource = UserCvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

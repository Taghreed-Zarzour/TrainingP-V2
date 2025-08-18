<?php

namespace App\Filament\Resources\UserCvs\Pages;

use App\Filament\Resources\UserCvs\UserCvResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserCv extends EditRecord
{
    protected static string $resource = UserCvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

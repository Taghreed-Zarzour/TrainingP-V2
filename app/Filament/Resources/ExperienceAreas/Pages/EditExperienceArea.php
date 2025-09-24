<?php

namespace App\Filament\Resources\ExperienceAreas\Pages;

use App\Filament\Resources\ExperienceAreas\ExperienceAreaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExperienceArea extends EditRecord
{
    protected static string $resource = ExperienceAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\ExperienceAreas\Pages;

use App\Filament\Resources\ExperienceAreas\ExperienceAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExperienceAreas extends ListRecords
{
    protected static string $resource = ExperienceAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

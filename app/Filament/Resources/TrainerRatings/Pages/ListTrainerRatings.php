<?php

namespace App\Filament\Resources\TrainerRatings\Pages;

use App\Filament\Resources\TrainerRatings\TrainerRatingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainerRatings extends ListRecords
{
    protected static string $resource = TrainerRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

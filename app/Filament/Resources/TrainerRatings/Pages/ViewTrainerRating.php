<?php

namespace App\Filament\Resources\TrainerRatings\Pages;

use App\Filament\Resources\TrainerRatings\TrainerRatingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainerRating extends ViewRecord
{
    protected static string $resource = TrainerRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

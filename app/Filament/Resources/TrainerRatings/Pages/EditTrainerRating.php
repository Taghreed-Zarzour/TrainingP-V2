<?php

namespace App\Filament\Resources\TrainerRatings\Pages;

use App\Filament\Resources\TrainerRatings\TrainerRatingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainerRating extends EditRecord
{
    protected static string $resource = TrainerRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\AnnualBudgets\Pages;

use App\Filament\Resources\AnnualBudgets\AnnualBudgetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAnnualBudget extends EditRecord
{
    protected static string $resource = AnnualBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\AnnualBudgets\Pages;

use App\Filament\Resources\AnnualBudgets\AnnualBudgetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnnualBudgets extends ListRecords
{
    protected static string $resource = AnnualBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

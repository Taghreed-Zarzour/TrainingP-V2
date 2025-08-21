<?php

namespace App\Filament\Resources\AnnualBudgets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnnualBudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\EmployeeNumbers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeNumberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('range')
                    ->required(),
            ]);
    }
}

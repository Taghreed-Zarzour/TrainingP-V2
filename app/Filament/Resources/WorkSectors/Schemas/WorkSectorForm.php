<?php

namespace App\Filament\Resources\WorkSectors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkSectorForm
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

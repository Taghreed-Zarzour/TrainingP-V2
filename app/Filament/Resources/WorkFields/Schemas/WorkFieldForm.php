<?php

namespace App\Filament\Resources\WorkFields\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkFieldForm
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

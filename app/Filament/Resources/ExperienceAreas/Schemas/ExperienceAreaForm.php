<?php

namespace App\Filament\Resources\ExperienceAreas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExperienceAreaForm
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

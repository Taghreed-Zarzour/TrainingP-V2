<?php

namespace App\Filament\Resources\EducationLevels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EducationLevelForm
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

<?php

namespace App\Filament\Resources\TrainingLevels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TrainingLevelForm
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

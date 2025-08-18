<?php

namespace App\Filament\Resources\UserCvs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserCvForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cv_file')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}

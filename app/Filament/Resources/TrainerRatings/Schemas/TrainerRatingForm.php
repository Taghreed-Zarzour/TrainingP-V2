<?php

namespace App\Filament\Resources\TrainerRatings\Schemas;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;


class TrainerRatingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('trainee_id')
                    ->label('Trainee')
                    ->required()
                    ->options(User::where('user_type_id', 3)->pluck('name', 'id'))
                    ->searchable(),

                Select::make('trainer_id')
                    ->label('Trainer')
                    ->required()
                    ->options(User::where('user_type_id', 1)->pluck('name', 'id'))
                    ->searchable(),

                Textarea::make('comment')
                    ->default(null)
                    ->columnSpanFull(),

                Select::make('clarity')
                    ->label('Clarity')
                    ->required()
                    ->options([
                        1 => '⭐',
                        2 => '⭐⭐',
                        3 => '⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        5 => '⭐⭐⭐⭐⭐',
                    ]),

                Select::make('interaction')
                    ->label('Interaction')
                    ->required()
                    ->options([
                        1 => '⭐',
                        2 => '⭐⭐',
                        3 => '⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        5 => '⭐⭐⭐⭐⭐',
                    ]),

                Select::make('organization')
                    ->label('Organization')
                    ->required()
                    ->options([
                        1 => '⭐',
                        2 => '⭐⭐',
                        3 => '⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        5 => '⭐⭐⭐⭐⭐',
                    ]),
            ]);

    }
}

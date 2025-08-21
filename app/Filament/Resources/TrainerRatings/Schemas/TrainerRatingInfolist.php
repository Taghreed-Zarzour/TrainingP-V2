<?php

namespace App\Filament\Resources\TrainerRatings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TrainerRatingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trainee.user.name')
                    ->label('trainee')
                    ->numeric(),
                TextEntry::make('trainer.user.name')
                    ->label('trainer')
                    ->numeric(),
                TextEntry::make('comment'),
                TextEntry::make('clarity')
                    ->label('Clarity')
                    ->html()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),
                TextEntry::make('interaction')
                    ->label('Interaction')
                    ->html()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),
                TextEntry::make('organization')
                    ->label('Organization')
                    ->html()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

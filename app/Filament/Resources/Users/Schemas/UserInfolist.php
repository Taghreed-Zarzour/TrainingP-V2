<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid as ComponentsGrid;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->getTranslation('name', 'en') . ' / ' . $record->getTranslation('name', 'ar');
                    }),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime(),
                TextEntry::make('userType.type')
                    ->numeric(),
                TextEntry::make('bio'),
                TextEntry::make('country.name')
                    ->label('country')
                    ->numeric(),
                TextEntry::make('city'),
                TextEntry::make('phone_code'),
                TextEntry::make('phone_number'),
                TextEntry::make('photo')
                    ->label('photo')
                    ->formatStateUsing(function ($state) {
                        $url = asset('storage/' . $state);

                        return <<<HTML
                            <img src="{$url}" alt="User Photo" class="h-10 w-10 rounded-full object-cover border" />
                        HTML;
                    })
                    ->html(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

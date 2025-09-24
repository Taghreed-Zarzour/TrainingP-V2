<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;

use App\Models\UserType;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsGrid::make(2)
                    ->schema([
                        TextInput::make('name.en')
                            ->label('Name (English)'),
                        TextInput::make('name.ar')
                            ->label('Name (Arabic)')
                            ->required(),
                    ]),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->placeholder('Leave blank to keep current')
                    ->dehydrated(fn ($state) => filled($state)) // only save if filled
                    ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null)
                    ->required(fn (string $context) => $context === 'create'), // required only on create

                Select::make('user_type_id')
                    ->label('User Type')
                    ->options(UserType::all()->pluck('type', 'id')->toArray())
                    ->required(),
                TextInput::make('bio')
                    ->default(null),

                Select::make('country_id')
                    ->label('country')
                    ->options(
                        Country::pluck('name', 'id')->toArray()
                    )
                    ->reactive()
                    ->required(),

                Select::make('city')
                    ->label('city')
                    ->options(function (callable $get) {
                        $countryId = $get('country_id');
                        if (! $countryId) {
                            return [];
                        }
                        $cities = collect(json_decode(file_get_contents(public_path('assets/states.json')), true));

                        return $cities
                            ->where('country_id', $countryId)
                            ->pluck('name', 'name')
                            ->toArray();
                    })
                    ->reactive()
                    ->required(),

                TextInput::make('phone_code')
                    ->tel()
                    ->default(null),
                TextInput::make('phone_number')
                    ->tel()
                    ->default(null),
                FileUpload::make('photo')
                    ->directory('photos')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->enableOpen()
                    ->preserveFilenames()
                    ->visible(fn (?User $record) => blank($record?->photo)),
                TextEntry::make('photo')
                    ->label('Photo')
                    ->formatStateUsing(function ($state) {
                        $url = asset('storage/' . $state);
                        return <<<HTML
                            <img src="{$url}" alt="User Photo" class="h-5 w-5 rounded-full object-cover border" />
                        HTML;
                    })
                    ->html()
                    ->visible(fn (?User $record) => filled($record?->photo))

            ]);
    }
}
<?php

namespace App\Filament\Resources\UserTypes;

use App\Filament\Resources\UserTypes\Pages\CreateUserType;
use App\Filament\Resources\UserTypes\Pages\EditUserType;
use App\Filament\Resources\UserTypes\Pages\ListUserTypes;
use App\Filament\Resources\UserTypes\Schemas\UserTypeForm;
use App\Filament\Resources\UserTypes\Tables\UserTypesTable;
use App\Models\UserType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserTypeResource extends Resource
{
    protected static ?string $model = UserType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User Types';

    public static function form(Schema $schema): Schema
    {
        return UserTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserTypes::route('/'),
            'create' => CreateUserType::route('/create'),
            'edit' => EditUserType::route('/{record}/edit'),
        ];
    }
}

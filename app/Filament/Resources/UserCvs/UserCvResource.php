<?php

namespace App\Filament\Resources\UserCvs;

use App\Filament\Resources\UserCvs\Pages\CreateUserCv;
use App\Filament\Resources\UserCvs\Pages\EditUserCv;
use App\Filament\Resources\UserCvs\Pages\ListUserCvs;
use App\Filament\Resources\UserCvs\Pages\ViewUserCv;
use App\Filament\Resources\UserCvs\Schemas\UserCvForm;
use App\Filament\Resources\UserCvs\Schemas\UserCvInfolist;
use App\Filament\Resources\UserCvs\Tables\UserCvsTable;
use App\Models\UserCv;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserCvResource extends Resource
{
    protected static ?string $model = UserCv::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Users Cv';

    public static function form(Schema $schema): Schema
    {
        return UserCvForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserCvInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserCvsTable::configure($table);
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
            'index' => ListUserCvs::route('/'),
            'create' => CreateUserCv::route('/create'),
            'view' => ViewUserCv::route('/{record}'),
            'edit' => EditUserCv::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\EmployeeNumbers;

use App\Filament\Resources\EmployeeNumbers\Pages\CreateEmployeeNumber;
use App\Filament\Resources\EmployeeNumbers\Pages\EditEmployeeNumber;
use App\Filament\Resources\EmployeeNumbers\Pages\ListEmployeeNumbers;
use App\Filament\Resources\EmployeeNumbers\Schemas\EmployeeNumberForm;
use App\Filament\Resources\EmployeeNumbers\Tables\EmployeeNumbersTable;
use App\Models\EmployeeNumber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmployeeNumberResource extends Resource
{
    protected static ?string $model = EmployeeNumber::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Employee Numbers';

    public static function form(Schema $schema): Schema
    {
        return EmployeeNumberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeNumbersTable::configure($table);
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
            'index' => ListEmployeeNumbers::route('/'),
            'create' => CreateEmployeeNumber::route('/create'),
            'edit' => EditEmployeeNumber::route('/{record}/edit'),
        ];
    }
}

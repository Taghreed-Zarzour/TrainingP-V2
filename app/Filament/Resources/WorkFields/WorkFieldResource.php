<?php

namespace App\Filament\Resources\WorkFields;

use App\Filament\Resources\WorkFields\Pages\CreateWorkField;
use App\Filament\Resources\WorkFields\Pages\EditWorkField;
use App\Filament\Resources\WorkFields\Pages\ListWorkFields;
use App\Filament\Resources\WorkFields\Schemas\WorkFieldForm;
use App\Filament\Resources\WorkFields\Tables\WorkFieldsTable;
use App\Models\WorkField;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkFieldResource extends Resource
{
    protected static ?string $model = WorkField::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Work Fields';

    public static function form(Schema $schema): Schema
    {
        return WorkFieldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkFieldsTable::configure($table);
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
            'index' => ListWorkFields::route('/'),
            'create' => CreateWorkField::route('/create'),
            'edit' => EditWorkField::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\WorkSectors;

use App\Filament\Resources\WorkSectors\Pages\CreateWorkSector;
use App\Filament\Resources\WorkSectors\Pages\EditWorkSector;
use App\Filament\Resources\WorkSectors\Pages\ListWorkSectors;
use App\Filament\Resources\WorkSectors\Schemas\WorkSectorForm;
use App\Filament\Resources\WorkSectors\Tables\WorkSectorsTable;
use App\Models\WorkSector;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkSectorResource extends Resource
{
    protected static ?string $model = WorkSector::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Work Sector';

    public static function form(Schema $schema): Schema
    {
        return WorkSectorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkSectorsTable::configure($table);
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
            'index' => ListWorkSectors::route('/'),
            'create' => CreateWorkSector::route('/create'),
            'edit' => EditWorkSector::route('/{record}/edit'),
        ];
    }
}

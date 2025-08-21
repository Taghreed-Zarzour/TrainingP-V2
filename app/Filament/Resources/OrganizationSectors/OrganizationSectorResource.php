<?php

namespace App\Filament\Resources\OrganizationSectors;

use App\Filament\Resources\OrganizationSectors\Pages\CreateOrganizationSector;
use App\Filament\Resources\OrganizationSectors\Pages\EditOrganizationSector;
use App\Filament\Resources\OrganizationSectors\Pages\ListOrganizationSectors;
use App\Filament\Resources\OrganizationSectors\Schemas\OrganizationSectorForm;
use App\Filament\Resources\OrganizationSectors\Tables\OrganizationSectorsTable;
use App\Models\OrganizationSector;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrganizationSectorResource extends Resource
{
    protected static ?string $model = OrganizationSector::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Organization Sectors';

    public static function form(Schema $schema): Schema
    {
        return OrganizationSectorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationSectorsTable::configure($table);
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
            'index' => ListOrganizationSectors::route('/'),
            'create' => CreateOrganizationSector::route('/create'),
            'edit' => EditOrganizationSector::route('/{record}/edit'),
        ];
    }
}

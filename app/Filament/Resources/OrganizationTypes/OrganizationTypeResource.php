<?php

namespace App\Filament\Resources\OrganizationTypes;

use App\Filament\Resources\OrganizationTypes\Pages\CreateOrganizationType;
use App\Filament\Resources\OrganizationTypes\Pages\EditOrganizationType;
use App\Filament\Resources\OrganizationTypes\Pages\ListOrganizationTypes;
use App\Filament\Resources\OrganizationTypes\Schemas\OrganizationTypeForm;
use App\Filament\Resources\OrganizationTypes\Tables\OrganizationTypesTable;
use App\Models\OrganizationType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrganizationTypeResource extends Resource
{
    protected static ?string $model = OrganizationType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Organization Types';

    public static function form(Schema $schema): Schema
    {
        return OrganizationTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationTypesTable::configure($table);
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
            'index' => ListOrganizationTypes::route('/'),
            'create' => CreateOrganizationType::route('/create'),
            'edit' => EditOrganizationType::route('/{record}/edit'),
        ];
    }
}

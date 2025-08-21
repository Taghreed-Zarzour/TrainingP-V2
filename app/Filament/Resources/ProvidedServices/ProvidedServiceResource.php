<?php

namespace App\Filament\Resources\ProvidedServices;

use App\Filament\Resources\ProvidedServices\Pages\CreateProvidedService;
use App\Filament\Resources\ProvidedServices\Pages\EditProvidedService;
use App\Filament\Resources\ProvidedServices\Pages\ListProvidedServices;
use App\Filament\Resources\ProvidedServices\Schemas\ProvidedServiceForm;
use App\Filament\Resources\ProvidedServices\Tables\ProvidedServicesTable;
use App\Models\ProvidedService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProvidedServiceResource extends Resource
{
    protected static ?string $model = ProvidedService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Provided Services';

    public static function form(Schema $schema): Schema
    {
        return ProvidedServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProvidedServicesTable::configure($table);
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
            'index' => ListProvidedServices::route('/'),
            'create' => CreateProvidedService::route('/create'),
            'edit' => EditProvidedService::route('/{record}/edit'),
        ];
    }
}

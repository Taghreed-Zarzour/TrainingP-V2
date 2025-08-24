<?php

namespace App\Filament\Resources\OrgTrainingDetails;

use App\Filament\Resources\OrgTrainingDetails\Pages\CreateOrgTrainingDetail;
use App\Filament\Resources\OrgTrainingDetails\Pages\EditOrgTrainingDetail;
use App\Filament\Resources\OrgTrainingDetails\Pages\ListOrgTrainingDetails;
use App\Filament\Resources\OrgTrainingDetails\Pages\ViewOrgTrainingDetail;
use App\Filament\Resources\OrgTrainingDetails\RelationManagers\TrainingSchedulesRelationManager;
use App\Filament\Resources\OrgTrainingDetails\Schemas\OrgTrainingDetailForm;
use App\Filament\Resources\OrgTrainingDetails\Schemas\OrgTrainingDetailInfolist;
use App\Filament\Resources\OrgTrainingDetails\Tables\OrgTrainingDetailsTable;
use App\Models\OrgTrainingDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrgTrainingDetailResource extends Resource
{
    protected static ?string $model = OrgTrainingDetail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'OrgTrainingDetail';

    public static function form(Schema $schema): Schema
    {
        return OrgTrainingDetailForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrgTrainingDetailInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrgTrainingDetailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TrainingSchedulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrgTrainingDetails::route('/'),
            'create' => CreateOrgTrainingDetail::route('/create'),
            'view' => ViewOrgTrainingDetail::route('/{record}'),
            'edit' => EditOrgTrainingDetail::route('/{record}/edit'),
        ];
    }
}

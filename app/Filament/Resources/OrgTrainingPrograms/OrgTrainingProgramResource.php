<?php

namespace App\Filament\Resources\OrgTrainingPrograms;

use App\Filament\Resources\OrgTrainingPrograms\Pages\CreateOrgTrainingProgram;
use App\Filament\Resources\OrgTrainingPrograms\Pages\EditOrgTrainingProgram;
use App\Filament\Resources\OrgTrainingPrograms\Pages\ListOrgTrainingPrograms;
use App\Filament\Resources\OrgTrainingPrograms\Pages\ViewOrgTrainingProgram;
use App\Filament\Resources\OrgTrainingPrograms\RelationManagers\GoalsRelationManager;
use App\Filament\Resources\OrgTrainingPrograms\Schemas\OrgTrainingProgramForm;
use App\Filament\Resources\OrgTrainingPrograms\Schemas\OrgTrainingProgramInfolist;
use App\Filament\Resources\OrgTrainingPrograms\Tables\OrgTrainingProgramsTable;
use App\Models\OrgTrainingProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrgTrainingProgramResource extends Resource
{
    protected static ?string $model = OrgTrainingProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Organization Training Programs';

    public static function form(Schema $schema): Schema
    {
        return OrgTrainingProgramForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrgTrainingProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrgTrainingProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            GoalsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrgTrainingPrograms::route('/'),
            'create' => CreateOrgTrainingProgram::route('/create'),
            'view' => ViewOrgTrainingProgram::route('/{record}'),
            'edit' => EditOrgTrainingProgram::route('/{record}/edit'),
        ];
    }
}

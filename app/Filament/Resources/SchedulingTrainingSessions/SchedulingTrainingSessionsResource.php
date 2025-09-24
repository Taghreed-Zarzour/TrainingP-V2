<?php

namespace App\Filament\Resources\SchedulingTrainingSessions;

use App\Filament\Resources\SchedulingTrainingSessions\Pages\CreateSchedulingTrainingSessions;
use App\Filament\Resources\SchedulingTrainingSessions\Pages\EditSchedulingTrainingSessions;
use App\Filament\Resources\SchedulingTrainingSessions\Pages\ListSchedulingTrainingSessions;
use App\Filament\Resources\SchedulingTrainingSessions\Pages\ViewSchedulingTrainingSessions;
use App\Filament\Resources\SchedulingTrainingSessions\RelationManagers\SessionRelationManager;
use App\Filament\Resources\SchedulingTrainingSessions\Schemas\SchedulingTrainingSessionsForm;
use App\Filament\Resources\SchedulingTrainingSessions\Schemas\SchedulingTrainingSessionsInfolist;
use App\Filament\Resources\SchedulingTrainingSessions\Tables\SchedulingTrainingSessionsTable;
use App\Models\SchedulingTrainingSessions;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SchedulingTrainingSessionsResource extends Resource
{
    protected static ?string $model = SchedulingTrainingSessions::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Training Sessions';

    public static function form(Schema $schema): Schema
    {
        return SchedulingTrainingSessionsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SchedulingTrainingSessionsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchedulingTrainingSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SessionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchedulingTrainingSessions::route('/'),
            'create' => CreateSchedulingTrainingSessions::route('/create'),
            'view' => ViewSchedulingTrainingSessions::route('/{record}'),
            'edit' => EditSchedulingTrainingSessions::route('/{record}/edit'),
        ];
    }
}

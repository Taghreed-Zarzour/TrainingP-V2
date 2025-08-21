<?php

namespace App\Filament\Resources\Trainees;

use App\Filament\Resources\Trainees\Pages\CreateTrainee;
use App\Filament\Resources\Trainees\Pages\EditTrainee;
use App\Filament\Resources\Trainees\Pages\ListTrainees;
use App\Filament\Resources\Trainees\Pages\ViewTrainee;
use App\Filament\Resources\Trainees\RelationManagers\UserRelationManager;
use App\Filament\Resources\Trainees\Schemas\TraineeForm;
use App\Filament\Resources\Trainees\Schemas\TraineeInfolist;
use App\Filament\Resources\Trainees\Tables\TraineesTable;
use App\Models\Trainee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TraineeResource extends Resource
{
    protected static ?string $model = Trainee::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Trainees';

    public static function form(Schema $schema): Schema
    {
        return TraineeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TraineeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TraineesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            UserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainees::route('/'),
            'create' => CreateTrainee::route('/create'),
            'view' => ViewTrainee::route('/{record}'),
            'edit' => EditTrainee::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\TrainingLevels;

use App\Filament\Resources\TrainingLevels\Pages\CreateTrainingLevel;
use App\Filament\Resources\TrainingLevels\Pages\EditTrainingLevel;
use App\Filament\Resources\TrainingLevels\Pages\ListTrainingLevels;
use App\Filament\Resources\TrainingLevels\Schemas\TrainingLevelForm;
use App\Filament\Resources\TrainingLevels\Tables\TrainingLevelsTable;
use App\Models\TrainingLevel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingLevelResource extends Resource
{
    protected static ?string $model = TrainingLevel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Training levels';

    public static function form(Schema $schema): Schema
    {
        return TrainingLevelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingLevelsTable::configure($table);
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
            'index' => ListTrainingLevels::route('/'),
            'create' => CreateTrainingLevel::route('/create'),
            'edit' => EditTrainingLevel::route('/{record}/edit'),
        ];
    }
}

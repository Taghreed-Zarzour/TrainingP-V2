<?php

namespace App\Filament\Resources\TrainingClassifications;

use App\Filament\Resources\TrainingClassifications\Pages\CreateTrainingClassification;
use App\Filament\Resources\TrainingClassifications\Pages\EditTrainingClassification;
use App\Filament\Resources\TrainingClassifications\Pages\ListTrainingClassifications;
use App\Filament\Resources\TrainingClassifications\Schemas\TrainingClassificationForm;
use App\Filament\Resources\TrainingClassifications\Tables\TrainingClassificationsTable;
use App\Models\TrainingClassification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingClassificationResource extends Resource
{
    protected static ?string $model = TrainingClassification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Training Classifications';

    public static function form(Schema $schema): Schema
    {
        return TrainingClassificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingClassificationsTable::configure($table);
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
            'index' => ListTrainingClassifications::route('/'),
            'create' => CreateTrainingClassification::route('/create'),
            'edit' => EditTrainingClassification::route('/{record}/edit'),
        ];
    }
}

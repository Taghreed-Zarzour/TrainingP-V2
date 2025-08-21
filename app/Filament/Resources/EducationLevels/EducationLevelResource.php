<?php

namespace App\Filament\Resources\EducationLevels;

use App\Filament\Resources\EducationLevels\Pages\CreateEducationLevel;
use App\Filament\Resources\EducationLevels\Pages\EditEducationLevel;
use App\Filament\Resources\EducationLevels\Pages\ListEducationLevels;
use App\Filament\Resources\EducationLevels\Schemas\EducationLevelForm;
use App\Filament\Resources\EducationLevels\Tables\EducationLevelsTable;
use App\Models\EducationLevel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EducationLevelResource extends Resource
{
    protected static ?string $model = EducationLevel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Education Levels';

    public static function form(Schema $schema): Schema
    {
        return EducationLevelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EducationLevelsTable::configure($table);
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
            'index' => ListEducationLevels::route('/'),
            'create' => CreateEducationLevel::route('/create'),
            'edit' => EditEducationLevel::route('/{record}/edit'),
        ];
    }
}

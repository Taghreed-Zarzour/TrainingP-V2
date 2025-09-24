<?php

namespace App\Filament\Resources\ExperienceAreas;

use App\Filament\Resources\ExperienceAreas\Pages\CreateExperienceArea;
use App\Filament\Resources\ExperienceAreas\Pages\EditExperienceArea;
use App\Filament\Resources\ExperienceAreas\Pages\ListExperienceAreas;
use App\Filament\Resources\ExperienceAreas\Schemas\ExperienceAreaForm;
use App\Filament\Resources\ExperienceAreas\Tables\ExperienceAreasTable;
use App\Models\ExperienceArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExperienceAreaResource extends Resource
{
    protected static ?string $model = ExperienceArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Experience Areas';

    public static function form(Schema $schema): Schema
    {
        return ExperienceAreaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExperienceAreasTable::configure($table);
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
            'index' => ListExperienceAreas::route('/'),
            'create' => CreateExperienceArea::route('/create'),
            'edit' => EditExperienceArea::route('/{record}/edit'),
        ];
    }
}

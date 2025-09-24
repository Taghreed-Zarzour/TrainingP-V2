<?php

namespace App\Filament\Resources\TrainerRatings;

use App\Filament\Resources\TrainerRatings\Pages\CreateTrainerRating;
use App\Filament\Resources\TrainerRatings\Pages\EditTrainerRating;
use App\Filament\Resources\TrainerRatings\Pages\ListTrainerRatings;
use App\Filament\Resources\TrainerRatings\Pages\ViewTrainerRating;
use App\Filament\Resources\TrainerRatings\Schemas\TrainerRatingForm;
use App\Filament\Resources\TrainerRatings\Schemas\TrainerRatingInfolist;
use App\Filament\Resources\TrainerRatings\Tables\TrainerRatingsTable;
use App\Models\TrainerRating;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainerRatingResource extends Resource
{
    protected static ?string $model = TrainerRating::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Trainer Ratings';

    public static function form(Schema $schema): Schema
    {
        return TrainerRatingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainerRatingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainerRatingsTable::configure($table);
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
            'index' => ListTrainerRatings::route('/'),
            'create' => CreateTrainerRating::route('/create'),
            'view' => ViewTrainerRating::route('/{record}'),
            'edit' => EditTrainerRating::route('/{record}/edit'),
        ];
    }
}

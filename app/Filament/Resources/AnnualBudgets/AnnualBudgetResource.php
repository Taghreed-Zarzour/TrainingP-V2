<?php

namespace App\Filament\Resources\AnnualBudgets;

use App\Filament\Resources\AnnualBudgets\Pages\CreateAnnualBudget;
use App\Filament\Resources\AnnualBudgets\Pages\EditAnnualBudget;
use App\Filament\Resources\AnnualBudgets\Pages\ListAnnualBudgets;
use App\Filament\Resources\AnnualBudgets\Schemas\AnnualBudgetForm;
use App\Filament\Resources\AnnualBudgets\Tables\AnnualBudgetsTable;
use App\Models\AnnualBudget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnnualBudgetResource extends Resource
{
    protected static ?string $model = AnnualBudget::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Annual Budget';

    public static function form(Schema $schema): Schema
    {
        return AnnualBudgetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnnualBudgetsTable::configure($table);
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
            'index' => ListAnnualBudgets::route('/'),
            'create' => CreateAnnualBudget::route('/create'),
            'edit' => EditAnnualBudget::route('/{record}/edit'),
        ];
    }
}

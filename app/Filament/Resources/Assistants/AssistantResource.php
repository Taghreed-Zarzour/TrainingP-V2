<?php

namespace App\Filament\Resources\Assistants;

use App\Filament\Resources\Assistants\Pages\CreateAssistant;
use App\Filament\Resources\Assistants\Pages\EditAssistant;
use App\Filament\Resources\Assistants\Pages\ListAssistants;
use App\Filament\Resources\Assistants\Pages\ViewAssistant;
use App\Filament\Resources\Assistants\RelationManagers\UserRelationManager;
use App\Filament\Resources\Assistants\Schemas\AssistantForm;
use App\Filament\Resources\Assistants\Schemas\AssistantInfolist;
use App\Filament\Resources\Assistants\Tables\AssistantsTable;
use App\Models\Assistant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssistantResource extends Resource
{
    protected static ?string $model = Assistant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Assistants';

    public static function form(Schema $schema): Schema
    {
        return AssistantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssistantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssistantsTable::configure($table);
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
            'index' => ListAssistants::route('/'),
            'create' => CreateAssistant::route('/create'),
            'view' => ViewAssistant::route('/{record}'),
            'edit' => EditAssistant::route('/{record}/edit'),
        ];
    }
}

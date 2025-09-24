<?php

namespace App\Filament\Resources\OrgTrainingPrograms\RelationManagers;

use App\Filament\Resources\OrgTrainingPrograms\OrgTrainingProgramResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssistantsRelationManager extends RelationManager
{
    protected static string $relationship = 'assistants';

    public function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('assistant_id')
                    ->label('Assistant')
                    ->formatStateUsing(fn ($state) => User::find($state)?->name ?? 'Unknown'),
            ])

            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

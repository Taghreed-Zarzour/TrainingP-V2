<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;



class AssistantsRelationManager extends RelationManager
{
    protected static string $relationship = 'assistants';


    

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('trainer_id')
                ->label('المدرب')
                ->options(function () {
                    return User::where('user_type_id', 1)
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->preload(),

            Select::make('assistant_id')
                ->label('المساعد')
                ->options(function () {
                    return User::where('user_type_id', 2)
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->preload(),
        ]);
    }


    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('trainer.name')->label('المدرب'),
            TextColumn::make('assistant.name')->label('المساعد'),
        ])

        ->headerActions([
            CreateAction::make(),
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);


    }
}

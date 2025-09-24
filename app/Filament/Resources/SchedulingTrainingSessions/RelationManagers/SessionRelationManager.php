<?php

namespace App\Filament\Resources\SchedulingTrainingSessions\RelationManagers;

use App\Filament\Resources\SchedulingTrainingSessions\SchedulingTrainingSessionsResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class SessionRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';


    public function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('session_id')
                ->label('Session ID')
                ->sortable()
                ->searchable(),

            TextColumn::make('trainee.user.name')
                ->label('Trainee ')
                ->sortable()
                ->searchable(),

            IconColumn::make('attended')
                ->label('Attended')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger')

        ])
        ->Actions([
            EditAction::make(),
        ])
        ->headerActions([
            CreateAction::make(),
        ]);


    }


    public function form(Schema $schema): Schema
{
    return $schema
        ->schema([
            Select::make('trainee_id')
                ->label('Trainee')
                ->relationship('trainee', 'user.name')
                ->searchable()
                ->required(),

            Toggle::make('attended')
                ->label('Attended')
                ->inline(false)
                ->required(),
        ]);
}


}

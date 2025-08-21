<?php

namespace App\Filament\Resources\Trainers\RelationManagers;

use App\Filament\Resources\Trainers\TrainerResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PreviousTrainingRelationManager extends RelationManager
{
    protected static string $relationship = 'previousTraining';

    public function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('training_title')
                ->label('Training Title')
                ->searchable()
                ->sortable(),

            TextColumn::make('description')
                ->label('Description')
                ->limit(50)
                ->wrap(),

            TextColumn::make('video_link')
                ->label('Video Link')
                ->url(fn($state) => $state) // Use the value itself as the URL
                ->openUrlInNewTab()
                ->copyable(),
        ])
        ->recordActions([
            EditAction::make(),
        ])

        ->headerActions([
            CreateAction::make(),
        ]);

    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
{
    return $schema->components([
        TextInput::make('training_title')
            ->label('Training Title')
            ->required(),

        Textarea::make('description')
            ->label('Description')
            ->required()
            ->rows(4),

        TextInput::make('video_link')
            ->label('Video Link')
            ->url()
            ->required(),
    ]);
}


}

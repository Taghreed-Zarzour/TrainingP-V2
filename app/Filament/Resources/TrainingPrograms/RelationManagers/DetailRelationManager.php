<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;



class DetailRelationManager extends RelationManager
{
    protected static string $relationship = 'detail';

    // protected static ?string $relatedResource = TrainingProgramResource::class;

    public function form(Schema $schema): Schema
{
    return $schema->schema([
        Textarea::make('benefits')
            ->label('Benefits')
            ->rows(4)
            ->helperText('Enter one benefit per line')
            ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n", $state) : $state)
            ->dehydrateStateUsing(fn ($state) => array_filter(array_map('trim', explode("\n", $state)))),

        Textarea::make('target_audience')
            ->label('Target Audience')
            ->rows(4)
            ->helperText('Enter one audience type per line')
            ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n", $state) : $state)
            ->dehydrateStateUsing(fn ($state) => array_filter(array_map('trim', explode("\n", $state)))),

        Textarea::make('requirements')
            ->label('Requirements')
            ->rows(4)
            ->helperText('Enter one requirement per line')
            ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n", $state) : $state)
            ->dehydrateStateUsing(fn ($state) => array_filter(array_map('trim', explode("\n", $state)))),

        Textarea::make('learning_outcomes')
            ->label('Learning Outcomes')
            ->rows(4)
            ->helperText('Enter one outcome per line')
            ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n", $state) : $state)
            ->dehydrateStateUsing(fn ($state) => array_filter(array_map('trim', explode("\n", $state)))),
    ]);
}



    function formatAsList($state): string {
        $items = is_string($state)
            ? json_decode($state, true) ?? []
            : (is_array($state) ? $state : [$state]);

        return '<ul style="padding-left: 1em;">' . implode('', array_map(fn ($item) => "<li>{$item}</li>", $items)) . '</ul>';
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('benefits')
                    ->label('Benefits')
                    ->formatStateUsing(fn ($state) => $this->formatAsList($state))
                    ->html()
                    ->wrap(),

                TextColumn::make('target_audience')
                    ->label('Target Audience')
                    ->formatStateUsing(fn ($state) => $this->formatAsList($state))
                    ->html()
                    ->wrap(),

                TextColumn::make('requirements')
                    ->label('Requirements')
                    ->formatStateUsing(fn ($state) => $this->formatAsList($state))
                    ->html()
                    ->wrap(),

                TextColumn::make('learning_outcomes')
                    ->label('Learning Outcomes')
                    ->formatStateUsing(fn ($state) => $this->formatAsList($state))
                    ->html()
                    ->wrap(),
            ])

            ->actions([
                EditAction::make(),
            ]);

    }



}

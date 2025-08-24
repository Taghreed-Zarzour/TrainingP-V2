<?php

namespace App\Filament\Resources\OrgTrainingPrograms\RelationManagers;

use App\Filament\Resources\OrgTrainingPrograms\OrgTrainingProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationRequirementsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrationRequirements';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('training_image')
                    ->label('Training Image')
                    ->disk('public') 
                    ->height(80),
                TextColumn::make('cost')->label('Cost'),
                IconColumn::make('is_free')
                    ->label('is free')
                    ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->tooltip(fn ($state) => $state ? 'Free' : 'Paid'),
                TextColumn::make('currency')->label('Currency'),
                TextColumn::make('payment_method')->label('Payment Method'),
                TextColumn::make('application_deadline')->label('Deadline')->date(),
                TextColumn::make('max_trainees')->label('Max Trainees'),
                TextColumn::make('application_submission_method')->label('Submission Method'),
                TextColumn::make('registration_link')->label('Link'),
                TextColumn::make('welcome_message')->label('Welcome Message')->limit(50),
                TextColumn::make('requirements')
                ->label('Requirements')
                ->formatStateUsing(function ($state) {
                    $decoded = is_string($state) ? json_decode($state, true) : $state;
                    return is_array($decoded) ? implode(', ', $decoded) : $state;
                }),

                TextColumn::make('benefits')
                    ->label('Benefits')
                    ->formatStateUsing(function ($state) {
                        $decoded = is_string($state) ? json_decode($state, true) : $state;
                        return is_array($decoded) ? implode(', ', $decoded) : $state;
                    }),


            ])

            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

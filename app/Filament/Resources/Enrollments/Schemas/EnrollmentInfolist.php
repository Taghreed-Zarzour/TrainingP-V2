<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EnrollmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trainee.user.name')
                    ->numeric(),
                TextEntry::make('trainingProgram.title')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('registered_at')
                    ->dateTime(),
                TextEntry::make('rejection_reason'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

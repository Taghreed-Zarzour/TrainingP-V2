<?php

namespace App\Filament\Resources\Organizations\Schemas;

use App\Models\Country;
use App\Models\OrganizationSector;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrganizationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),

                TextEntry::make('type.name')
                    ->label('Organization Type')
                    ->numeric(),

                TextEntry::make('website')
                    ->label('Website'),

                TextEntry::make('employeeNumber.range')
                    ->label('Employee Range')
                    ->numeric(),

                TextEntry::make('established_year')
                    ->label('Established Year'),

                TextEntry::make('annualBudget.name')
                    ->label('Annual Budget')
                    ->numeric(),

                TextEntry::make('branches')
                    ->label('Branches')
                    ->formatStateUsing(function ($state) {
                        $branch = is_string($state) ? json_decode($state, true) : $state;
                        if (!is_array($branch) || !isset($branch['country_id'], $branch['city'])) {
                            return '—';
                        }
                        $countryName = Country::find((int) $branch['country_id'])?->name ?? 'Unknown';
                        $city = $branch['city'] ?? 'Unknown';

                        return "{$city}, {$countryName}";
                    }),
                TextEntry::make('organization_sectors')
                    ->label('Organization Sectors')
                    ->formatStateUsing(function ($state) {
                        $ids = collect(explode(',', $state))
                            ->map(fn($id) => (int) trim($id))
                            ->filter();

                        return $ids->isEmpty()
                            ? '—'
                            : OrganizationSector::whereIn('id', $ids)->pluck('name')->implode(', ');
                    }),

                TextEntry::make('created_at')
                    ->label('Created At')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Updated At')
                    ->dateTime(),
            ]);

    }
}

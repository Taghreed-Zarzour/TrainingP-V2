<?php

namespace App\Filament\Resources\Organizations\Schemas;

use App\Models\Country;
use App\Models\OrganizationSector;
use App\Models\User;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id')
                    ->label('User')
                    ->options(function () {
                        return User::query()
                            ->whereNotNull('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required(),


                Select::make('organization_type_id')
                    ->label('Organization Type')
                    ->relationship('type', 'name')
                    ->required(),

                TextInput::make('website')
                    ->label('Website')
                    ->required()
                    ->url(),

                Select::make('employee_numbers_id')
                    ->label('Employee Range')
                    ->relationship('employeeNumber', 'range')
                    ->required(),

                TextInput::make('established_year')
                    ->label('Established Year')
                    ->required()
                    ->numeric(),

                Select::make('annual_budgets_id')
                    ->label('Annual Budget')
                    ->relationship('annualBudget', 'name')
                    ->required(),

                    Repeater::make('branches')
                    ->label('Branches')
                    ->schema([
                        Select::make('country_id')
                            ->label('Country')
                            ->options(
                                Country::pluck('name_ar', 'id')->toArray()
                            )
                            ->reactive()
                            ->required(),

                        Select::make('city')
                            ->label('City')
                            ->options(function (callable $get) {
                                $countryId = $get('country_id');
                                if (! $countryId) {
                                    return [];
                                }

                                $cities = collect(
                                    json_decode(file_get_contents(public_path('assets/states.json')), true)
                                );

                                return $cities
                                    ->where('country_id', $countryId)
                                    ->pluck('name', 'name')
                                    ->toArray();
                            })
                            ->reactive()
                            ->required(),
                    ])
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->addActionLabel('Add Branch')
                    ->reorderable(false),


                Select::make('organization_sectors')
                    ->label('Organization Sectors')
                    ->multiple()
                    ->options(OrganizationSector::all()->pluck('name', 'id'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}

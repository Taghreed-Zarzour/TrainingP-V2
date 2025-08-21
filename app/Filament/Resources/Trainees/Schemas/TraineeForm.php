<?php

namespace App\Filament\Resources\Trainees\Schemas;

use App\Enums\SexEnum;
use App\Enums\TrainingAttendanceType;
use App\Models\Country;
use App\Models\WorkField;
use App\Models\WorkSector;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid as ComponentsGrid;

class TraineeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),


                ComponentsGrid::make(2)
                    ->schema([
                        TextInput::make('last_name.en')
                            ->label('Last Name (English)'),
                        TextInput::make('last_name.ar')
                            ->label('Last Name (Arabic)')
                            ->required(),
                    ]),
                Select::make('sex')
                    ->label('Sex')
                    ->options(SexEnum::class)
                    ->required(),

                Select::make('nationality')
                    ->label('Nationalities')
                    ->multiple()
                    ->options(fn () => Country::pluck('name_ar', 'id')->toArray())
                    ->columnSpanFull()
                    ->required()
                    ->saveRelationshipsUsing(function ($state) {
                        return implode(',', $state);
                    }),

                Select::make('work_fields')
                    ->label('Work Fields')
                    ->multiple()
                    ->options(fn () => WorkField::pluck('name', 'id')->toArray())
                    ->columnSpanFull()
                    ->required()
                    ->saveRelationshipsUsing(function ($state) {
                        return implode(',', $state);
                    }),

                TextInput::make('extra_work_field')
                    ->label('Extra Work Field')
                    ->default(null),

                Select::make('education_levels_id')
                    ->label('Education Level')
                    ->relationship('educationLevel', 'name')
                    ->required(),

                Select::make('fields_of_interest')
                    ->label('Fields of Interest')
                    ->multiple()
                    ->options([
                        'تحليل البيانات' =>  'تحليل البيانات',
                        'ذكاء صناعي' => 'ذكاء صناعي',
                        'مقدمة البرمجة' => 'مقدمة البرمجة',
                        'تطوير الويب' => 'تطوير الويب' ,
                    ])
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_working')
                    ->label('Currently Working')
                    ->required(),

                TextInput::make('job_position')
                    ->label('Job Position')
                    ->default(null),

                Select::make('work_sectors')
                    ->label('Work Sectors')
                    ->multiple()
                    ->options(fn () => WorkSector::pluck('name', 'id')->toArray())
                    ->columnSpanFull()
                    ->required()
                    ->saveRelationshipsUsing(function ($state) {
                        return implode(',', $state);
                    }),

                    Select::make('preferred_times')
                    ->label('Preferred Times')
                    ->multiple()
                    ->required()
                    ->options([
                        'sat_6_9_am' => 'Saturday 6-9 AM',
                        'sat_9_12_am' => 'Saturday 9-12 AM',
                        'sat_12_3_pm' => 'Saturday 12-3 PM',
                        'sat_3_6_pm' => 'Saturday 3-6 PM',
                        'sat_6_9_pm' => 'Saturday 6-9 PM',
                        'sat_9_12_pm' => 'Saturday 9-12 PM',

                        'sun_6_9_am' => 'Sunday 6-9 AM',
                        'sun_9_12_am' => 'Sunday 9-12 AM',
                        'sun_12_3_pm' => 'Sunday 12-3 PM',
                        'sun_3_6_pm' => 'Sunday 3-6 PM',
                        'sun_6_9_pm' => 'Sunday 6-9 PM',
                        'sun_9_12_pm' => 'Sunday 9-12 PM',

                        'mon_6_9_am' => 'Monday 6-9 AM',
                        'mon_9_12_am' => 'Monday 9-12 AM',
                        'mon_12_3_pm' => 'Monday 12-3 PM',
                        'mon_3_6_pm' => 'Monday 3-6 PM',
                        'mon_6_9_pm' => 'Monday 6-9 PM',
                        'mon_9_12_pm' => 'Monday 9-12 PM',

                        'tue_6_9_am' => 'Tuesday 6-9 AM',
                        'tue_9_12_am' => 'Tuesday 9-12 AM',
                        'tue_12_3_pm' => 'Tuesday 12-3 PM',
                        'tue_3_6_pm' => 'Tuesday 3-6 PM',
                        'tue_6_9_pm' => 'Tuesday 6-9 PM',
                        'tue_9_12_pm' => 'Tuesday 9-12 PM',

                        'wed_6_9_am' => 'Wednesday 6-9 AM',
                        'wed_9_12_am' => 'Wednesday 9-12 AM',
                        'wed_12_3_pm' => 'Wednesday 12-3 PM',
                        'wed_3_6_pm' => 'Wednesday 3-6 PM',
                        'wed_6_9_pm' => 'Wednesday 6-9 PM',
                        'wed_9_12_pm' => 'Wednesday 9-12 PM',

                        'thu_6_9_am' => 'Thursday 6-9 AM',
                        'thu_9_12_am' => 'Thursday 9-12 AM',
                        'thu_12_3_pm' => 'Thursday 12-3 PM',
                        'thu_3_6_pm' => 'Thursday 3-6 PM',
                        'thu_6_9_pm' => 'Thursday 6-9 PM',
                        'thu_9_12_pm' => 'Thursday 9-12 PM',

                        'fri_6_9_am' => 'Friday 6-9 AM',
                        'fri_9_12_am' => 'Friday 9-12 AM',
                        'fri_12_3_pm' => 'Friday 12-3 PM',
                        'fri_3_6_pm' => 'Friday 3-6 PM',
                        'fri_6_9_pm' => 'Friday 6-9 PM',
                        'fri_9_12_pm' => 'Friday 9-12 PM',
                    ])
                    ->columnSpanFull(),


                Select::make('training_attendance')
                    ->label('Training Attendance')
                    ->options(TrainingAttendanceType::class)
                    ->required(),

                TextInput::make('work_institution')
                    ->label('Work Institution')
                    ->default(null),
            ]);

    }
}

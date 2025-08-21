<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use App\Models\Country;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;




class AdditionalSettingRelationManager extends RelationManager
{
    protected static string $relationship = 'AdditionalSetting';


    public function form(Schema $schema): Schema
{
    return $schema
        ->schema([
            Select::make('training_program_id')
                ->label('اسم البرنامج')
                ->relationship('trainingProgram', 'title')
                ->required(),

            Toggle::make('is_free')
                ->label('مجاني؟'),

            TextInput::make('cost')
                ->label('التكلفة')
                ->numeric()
                ->required()
                ->visible(fn ($get) => ! $get('is_free')),

            Select::make('currency')
                ->label('العملة')
                ->options([
                    'USD' => 'دولار',
                    'EUR' => 'يورو',
                    'SYP' => 'ليرة سورية',
                ])
                ->default('USD')
                ->required(),

            TextInput::make('payment_method')
                ->label('طريقة الدفع')
                ->required(),

            Select::make('country_id')
                ->label('الدولة')
                ->relationship('country', 'name')
                ->searchable()
                ->required()
                ->reactive(),


            TextInput::make('city')
                ->label('المدينة'),


            DatePicker::make('application_deadline')
                ->label('آخر موعد للتقديم')
                ->required(),

            TextInput::make('max_trainees')
                ->label('الحد الأقصى للمتدربين')
                ->numeric()
                ->required(),

            Select::make('application_submission_method')
                ->label('طريقة التقديم')
                ->options([
                    'inside_platform' => 'داخل المنصة',
                    'outside_platform' => 'خارج المنصة ',
                ])
                ->required(),

            TextInput::make('registration_link')
                ->label('رابط التسجيل')
                ->url(),

            FileUpload::make('profile_image')
                ->label('صورة البرنامج')
                ->image()
                ->directory('profile_images')
                ->disk('public')
                ->preserveFilenames()
                ->imagePreviewHeight('150')
                ->openable()
                ->downloadable(),

            Textarea::make('welcome_message')
                ->label('رسالة الترحيب')
                ->rows(3),
        ]);
}


    public function table(Table $table): Table
{
    return $table
        ->columns([
            IconColumn::make('is_free')
                ->label('مجاني؟')
                ->boolean(),

            TextColumn::make('cost')
                ->label('التكلفة')
                ->money(fn ($record) => $record->currency ?? 'USD'),

            TextColumn::make('payment_method')
                ->label('طريقة الدفع'),

            TextColumn::make('country.name')
                ->label('الدولة'),

            TextColumn::make('city')
                ->label('المدينة'),

            TextColumn::make('application_deadline')
                ->label('آخر موعد للتقديم')
                ->date(),

            TextColumn::make('max_trainees')
                ->label('الحد الأقصى للمتدربين'),

            BadgeColumn::make('application_submission_method')
                ->label('طريقة التقديم')
                ->colors([
                    'primary' => 'Online',
                    'warning' => 'Email',
                    'danger' => 'InPerson',
                ]),

            TextColumn::make('registration_link')
                ->label('رابط التسجيل')
                ->url(fn ($record) => $record->registration_link, true),

            ImageColumn::make('profile_image')
                ->label('صورة البرنامج')
                ->disk('public') // matches your storage disk
                ->height(60)     // optional: thumbnail size
                ->circular(),


            TextColumn::make('welcome_message')
                ->label('رسالة الترحيب')
                ->limit(30)
                ->tooltip(fn ($record) => $record->welcome_message),

            TextColumn::make('created_at')
                ->label('تاريخ الإنشاء')
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            // Add filters like country, is_free, or deadline range if needed
        ])
        ->actions([
            EditAction::make(),
        ]);

}

}

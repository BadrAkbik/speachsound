<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TraineeResource\Pages;
use App\Models\Trainee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TraineeResource extends Resource
{
    protected static ?string $model = Trainee::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.trainees_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.trainees');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.trainee');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.trainees');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return __('dashboard.The number of trainees');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('gender')
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->required(),
                TextInput::make('training_result')
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('general_rating')
                    ->maxLength(255)
                    ->default(null),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('trainer_type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('trainer_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('dashboard.name'))
                    ->searchable(),
                TextColumn::make('gender')
                    ->label(__('dashboard.gender'))
                    ->badge()
                    ->color(function ($record) {
                        return $record->gender == 'male' ? 'info' : 'danger';
                    }),
                TextColumn::make('date_of_birth')
                    ->label(__('dashboard.date_of_birth'))
                    ->date('Y/m/d')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('training_result')
                    ->label(__('dashboard.training_result'))
                    ->searchable(),
                TextColumn::make('general_rating')
                    ->label(__('dashboard.general_rating'))
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label(__('dashboard.start_date'))
                    ->date('Y/m/d')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('dashboard.end_date'))
                    ->date('Y/m/d')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('trainer_type')
                    ->label(__('dashboard.trainer_type'))
                    ->searchable(),
                TextColumn::make('trainer_id')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('dashboard.updated_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('dashboard.deleted_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainees::route('/'),
            'create' => Pages\CreateTrainee::route('/create'),
            'edit' => Pages\EditTrainee::route('/{record}/edit'),
        ];
    }
}

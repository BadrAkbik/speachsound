<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TraineeResource\Pages;
use App\Models\Trainee;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('dashboard.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('gender')
                            ->label(__('dashboard.gender'))
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label(__('dashboard.date_of_birth'))
                            ->required(),
                        TextInput::make('general_rating')
                            ->label(__('dashboard.general_rating'))
                            ->maxLength(255)
                            ->default(null),
                        DatePicker::make('start_date')
                            ->label(__('dashboard.start_date'))
                            ->required(),
                        DatePicker::make('end_date')
                            ->label(__('dashboard.end_date')),
                        MorphToSelect::make('trainer')
                            ->label(__('dashboard.trainer'))
                            ->types([
                                Type::make(User::class)->titleAttribute('name')->label(__('dashboard.parent')),
                            ])->preload()->searchable()
                    ])
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
                TextColumn::make('general_rating')
                    ->label(__('dashboard.general_rating'))
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label(__('dashboard.training_start_date'))
                    ->date('Y/m/d')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('dashboard.training_end_date'))
                    ->date('Y/m/d')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('trainer.name')
                    ->label(__('dashboard.trainer_name'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.created_at'))
                    ->dateTime('Y/m/d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('dashboard.deleted_at'))
                    ->dateTime('Y/m/d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
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

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Filament\Resources\TrainingResource\RelationManagers\WordsRelationManager;
use App\Models\Level;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.trainings_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.trainings_levels');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.training_level');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.trainings_levels');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(1)
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('dashboard.name'))
                            ->maxLength(255),
                        TextInput::make('success_rate')
                            ->label(__('dashboard.success_rate'))
                            ->numeric(),
                        TextInput::make('success_attempts')
                            ->label(__('dashboard.success_attempts'))
                            ->numeric(),
                        Select::make('parent_id')
                            ->label(__('dashboard.parent_level'))
                            ->hint(__('dashboard.optional'))
                            ->relationship('parent', 'name')
                            ->exists('trainings', 'id')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->default(null)
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
                TextColumn::make('parent.name')
                    ->label(__('dashboard.parent_level'))
                    ->searchable(),
                TextColumn::make('success_rate')
                    ->label(__('dashboard.success_rate'))
                    ->badge()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('success_attempts')
                    ->label(__('dashboard.success_attempts'))
                    ->badge()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.created_at'))
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            WordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}

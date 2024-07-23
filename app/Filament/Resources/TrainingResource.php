<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Models\Level;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
        return __('dashboard.trainings');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.training');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.trainings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name_ar')
                    ->label(__('dashboard.name_ar'))
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('name_en')
                    ->label(__('dashboard.name_en'))
                    ->maxLength(255)
                    ->default(null),
                Select::make('level_id')
                    ->label(__('dashboard.level'))
                    ->relationship('level')
                    ->exists('level', 'id')
                    ->live()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Level $record) => "{$record->name_en} - {$record->name_ar}"),
                FileUpload::make('audio')
                    ->default(null),
                FileUpload::make('images')
                    ->multiple()
                    ->columnSpanFull(),
                Textarea::make('words')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_ar')
                    ->label(__('dashboard.name_ar'))
                    ->searchable(),
                TextColumn::make('name_en')
                    ->label(__('dashboard.name_en'))
                    ->searchable(),
                TextColumn::make('level.name_ar')
                    ->label(__('dashboard.level_name_ar')),
                TextColumn::make('level.name_en')
                    ->label(__('dashboard.level_name_en')),
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
            //
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

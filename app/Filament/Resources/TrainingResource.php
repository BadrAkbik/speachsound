<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                Forms\Components\TextInput::make('name_ar')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('name_en')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('level_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('audio')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('images')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('words')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('audio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}

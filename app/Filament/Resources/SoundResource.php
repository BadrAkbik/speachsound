<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoundResource\Pages;
use App\Filament\Resources\SoundResource\RelationManagers;
use App\Models\Sound;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SoundResource extends Resource
{
    protected static ?string $model = Sound::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.trainings_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.sounds');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.sound');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.sounds');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sound')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('audio')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('start_age')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('end_age')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sound')
                    ->searchable(),
                Tables\Columns\TextColumn::make('audio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_age')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListSounds::route('/'),
            'create' => Pages\CreateSound::route('/create'),
            'edit' => Pages\EditSound::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Filament\Resources\LevelResource\RelationManagers;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;


    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.levels_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.levels');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.level');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.levels');
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
                Forms\Components\TextInput::make('age_group_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('gender'),
                Forms\Components\TextInput::make('success_rate')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('attemtps_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('age_group_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('success_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attemtps_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}

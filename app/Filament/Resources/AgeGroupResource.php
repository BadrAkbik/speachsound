<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgeGroupResource\Pages;
use App\Filament\Resources\AgeGroupResource\RelationManagers;
use App\Models\AgeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgeGroupResource extends Resource
{
    protected static ?string $model = AgeGroup::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.levels_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.age_groups');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.age_group');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.age_groups');
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
                Forms\Components\TextInput::make('from_age')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('to_age')
                    ->required()
                    ->numeric(),
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
                Tables\Columns\TextColumn::make('from_age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('to_age')
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
            'index' => Pages\ListAgeGroups::route('/'),
            'create' => Pages\CreateAgeGroup::route('/create'),
            'edit' => Pages\EditAgeGroup::route('/{record}/edit'),
        ];
    }
}

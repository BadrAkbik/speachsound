<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\Rating;
use App\Models\Test;
use App\Models\Trainee;
use Filament\Forms;
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

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.ratings_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.ratings');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.rating');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.ratings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('trainee_id')
                    ->label(__('dashboard.trainee'))
                    ->relationship('trainee')
                    ->exists('trainees', 'id')
                    ->live()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Trainee $record) => "{$record->name}"),
                Select::make('test_id')
                    ->label(__('dashboard.test'))
                    ->relationship('test')
                    ->exists('tests', 'id')
                    ->live()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Test $record) => "{$record->name_en} - {$record->name_ar}"),
                TextInput::make('degree')
                    ->required()
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainee.name')
                    ->label(__('dashboard.trainee_name')),
                TextColumn::make('test.name_en')
                    ->label(__('dashboard.test_name_en')),
                TextColumn::make('test.name_ar')
                    ->label(__('dashboard.test_name_ar')),
                TextColumn::make('degree')
                    ->numeric()
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
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}

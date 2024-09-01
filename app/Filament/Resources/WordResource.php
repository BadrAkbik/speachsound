<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WordResource\Pages;
use App\Filament\Resources\WordResource\RelationManagers;
use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WordResource extends Resource
{
    protected static ?string $model = Word::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.trainings_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.trainings_tests_segments');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.segment');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.trainings_tests_segments');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('words')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\TextInput::make('sound_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('training_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('images')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('words')
                    ->label(__('dashboard.segments')),
                TextColumn::make('for')
                    ->label(__('dashboard.for'))
                    ->formatStateUsing(fn(string $state): string => __("dashboard.{$state}"))
                    ->badge()
                    ->color(function ($record) {
                        return $record->for === 'training' ? 'success' : 'danger';
                    })
                    ->sortable(),
                TextColumn::make('sound.sound')
                    ->label(__('dashboard.the_sound'))
                    ->sortable(),
                TextColumn::make('training.name')
                    ->label(__('dashboard.training_name'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListWords::route('/'),
            'create' => Pages\CreateWord::route('/create'),
            'edit' => Pages\EditWord::route('/{record}/edit'),
        ];
    }
}

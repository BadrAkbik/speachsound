<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WordResource\Pages;
use App\Filament\Resources\WordResource\RelationManagers;
use App\Models\Sound;
use App\Models\Test;
use App\Models\Training;
use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Get;

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
                Section::make()
                    ->columns(2)
                    ->schema([
                        TagsInput::make('words')
                            ->helperText(__('dashboard.adding_words_hint'))
                            ->placeholder(__('dashboard.add_words_or_sentences'))
                            ->reorderable()
                            ->splitKeys(['Tab'])
                            ->required(),
                        Select::make('sound_id')
                            ->label(__('dashboard.sound'))
                            ->relationship('sound', 'sound')
                            ->exists('sounds', 'id')
                            ->searchable()
                            ->live()
                            ->preload()
                            ->required(),
                        FileUpload::make('images')
                            ->label(__('dashboard.image'))
                            ->disk('public')
                            ->previewable()
                            ->downloadable()
                            ->directory('images/words'),
                        ToggleButtons::make('for')
                            ->label(__('dashboard.for'))
                            ->options([
                                'training' => __('dashboard.training'),
                                'test' => __('dashboard.test')
                            ])
                            ->live()
                            ->inline()
                            ->icons(
                                ['percentage' => 'heroicon-m-percent-badge', 'amount' => 'heroicon-m-currency-dollar']
                            )
                            ->colors([
                                'training' => 'success',
                                'test' => 'danger',
                            ])
                            ->required(),
                        Select::make('test_id')
                            ->label(__('dashboard.test'))
                            ->helperText(__('dashboard.words_relation_helper'))
                            ->relationship('test', 'name')
                            ->exists('tests', 'id')
                            ->live()
                            ->preload()
                            ->required(fn(Get $get) => $get('for') == 'test')
                            ->disabled(fn(Get $get) => $get('for') == 'training'),
                        Select::make('training_id')
                            ->label(__('dashboard.training'))
                            ->relationship('training', 'name')
                            ->exists('trainings', 'id')
                            ->live()
                            ->preload()
                            ->required(fn(Get $get) => $get('for') == 'training')
                            ->disabled(fn(Get $get) => $get('for') == 'test'),
                    ])
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
                    ->label(__('dashboard.the_training_level'))
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

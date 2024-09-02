<?php

namespace App\Filament\Resources\TrainingResource\RelationManagers;

use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WordsRelationManager extends RelationManager
{
    protected static string $relationship = 'words';

    public static function getModelLabel(): string
    {
        return __('dashboard.segment');
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('dashboard.trainings_tests_segments');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TagsInput::make('words')
                            ->label(__('dashboard.segment'))
                            ->helperText(__('dashboard.adding_words_hint'))
                            ->placeholder(__('dashboard.add_words_or_sentences'))
                            ->reorderable()
                            ->splitKeys(['Tab'])
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('images')
                            ->label(__('dashboard.image'))
                            ->disk('public')
                            ->previewable()
                            ->downloadable()
                            ->directory('images/words')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('words')
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

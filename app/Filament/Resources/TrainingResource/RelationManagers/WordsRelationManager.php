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

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.trainings_segments');
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('dashboard.trainings_segments');
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
                TextColumn::make('training.name')
                    ->label(__('dashboard.the_training_level'))
                    ->sortable(),
                TextColumn::make('subTraining.name')
                    ->label(__('dashboard.sub_training_level'))
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
                Tables\Actions\AttachAction::make(),
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

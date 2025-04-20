<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoundProgressResource\Pages;
use App\Filament\Resources\SoundProgressResource\RelationManagers;
use App\Models\SoundProgress;
use Filament\Forms\Components\Section;
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

class SoundProgressResource extends Resource
{
    protected static ?string $model = SoundProgress::class;

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
                Section::make()
                    ->columns(2)
                    ->schema([
                        // Select::make('trainee_id')
                        //     ->label(__('dashboard.trainee'))
                        //     ->relationship('trainee', 'id')
                        //     ->exists('trainees', 'id')
                        //     ->live()
                        //     ->preload()
                        //     ->options(
                        //         function () {
                        //             return Trainee::pluck('name', 'id');
                        //         }
                        //     )
                        //     ->required(),
                        // Select::make('test_id')
                        //     ->label(__('dashboard.test'))
                        //     ->relationship('test', 'id')
                        //     ->exists('tests', 'id')
                        //     ->live()
                        //     ->preload()
                        //     ->options(
                        //         function () {
                        //             return Test::pluck('name', 'id');
                        //         }
                        //     )
                        //     ->required(),
                        TextInput::make('degree')
                            ->label(__('dashboard.degree'))
                            ->maxLength(255)
                            ->required()
                            ->numeric(),
                        Textarea::make('notes')
                            ->label(__('dashboard.notes'))
                            ->maxLength(65500),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainee.name')
                    ->label(__('dashboard.trainee_name')),
                TextColumn::make('test.name')
                    ->label(__('dashboard.test_name')),
                TextColumn::make('degree')
                    ->label(__('dashboard.degree'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.created_at'))
                    ->dateTime('Y/m/d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('dashboard.updated_at'))
                    ->dateTime('Y/m/d H:i:s')
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
            'index' => Pages\ListSoundProgresses::route('/'),
            'create' => Pages\CreateSoundProgress::route('/create'),
            'edit' => Pages\EditSoundProgress::route('/{record}/edit'),
        ];
    }
}

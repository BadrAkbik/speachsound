<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoundResource\Pages;
use App\Filament\Resources\SoundResource\RelationManagers\WordsRelationManager;
use App\Models\Sound;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

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
                Section::make()
                    ->schema([
                        TextInput::make('sound')
                            ->label(__('dashboard.the_sound'))
                            ->unique(Sound::class, 'sound', ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        Select::make('ageGroup')
                            ->label(__('dashboard.the_age_group'))
                            ->relationship('ageGroup', 'name')
                            ->exists('trainings', 'id')
                            ->live()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(1)->columnSpan(1),
                Section::make(__('dashboard.media'))
                    ->schema([
                        FileUpload::make('audio')
                            ->label(__('dashboard.audio'))
                            ->disk('local')
                            ->directory('audios')
                            ->downloadable(),
                        FileUpload::make('natural_videos')
                            ->label(__('dashboard.natural_face_video'))
                            ->disk('local')
                            ->directory('xray_videos')
                            ->downloadable(),
                        FileUpload::make('xray_videos')
                            ->label(__('dashboard.xray_face_video'))
                            ->disk('local')
                            ->directory('natural_videos')
                            ->downloadable(),
                    ])
                    ->columns(1)->columnSpan(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sound')
                    ->label(__('dashboard.the_sound'))
                    ->searchable(),
                ViewColumn::make('audio')
                    ->view('filament.tables.columns.audio')
                    ->disableClick()
                    ->width(325),
                TextColumn::make('ageGroup.from_age')
                    ->label(__('dashboard.from_age'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ageGroup.to_age')
                    ->label(__('dashboard.to_age'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.created_at'))
                    ->dateTime('Y/m/d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('viewAttachments')
                    ->label(__('dashboard.attachments_view'))
                    ->icon('heroicon-o-paper-clip')
                    ->color('gray')
                    ->modalHeading(__('dashboard.attachments'))
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalSubmitAction(false)
                    ->modalContent(function ($record) {
                        $id = $record->id;
                        if (isset($record->xray_videos) || isset($record->natural_videos)) {
                            return view('components.attachment-viewer', compact('id'));
                        }
                    }),
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
            'index' => Pages\ListSounds::route('/'),
            'create' => Pages\CreateSound::route('/create'),
            'edit' => Pages\EditSound::route('/{record}/edit'),
        ];
    }
}

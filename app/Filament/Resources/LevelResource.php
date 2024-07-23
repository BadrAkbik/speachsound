<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Filament\Resources\LevelResource\RelationManagers;
use App\Models\AgeGroup;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                TextInput::make('name_ar')
                    ->label(__('dashboard.name_ar'))
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('name_en')
                    ->label(__('dashboard.name_en'))
                    ->maxLength(255)
                    ->default(null),
                Select::make('age_group_id')
                    ->label(__('dashboard.age_group'))
                    ->relationship('ageGroup')
                    ->exists('age_groups', 'id')
                    ->live()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (AgeGroup $record) => "{$record->name_en} - {$record->name_ar}"),
                Select::make('gender')
                    ->label(__('dashboard.gender'))
                    ->enum('male', 'female')
                    ->options([
                        'male' => __('dashboard.males'),
                        'female' => __('dashboard.females'),
                        null => __('dashboard.both'),
                    ]),
                TextInput::make('success_rate')
                    ->label(__('dashboard.success_rate'))
                    ->numeric()
                    ->default(null),
                TextInput::make('attemtps_count')
                    ->label(__('dashboard.attemtps_count'))
                    ->numeric()
                    ->default(null),
                Select::make('status')
                    ->label(__('dashboard.status'))
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_ar')
                    ->label(__('dashboard.name_ar'))
                    ->searchable(),
                TextColumn::make('name_en')
                    ->label(__('dashboard.name_en'))
                    ->searchable(),
                TextColumn::make('ageGroup.name_ar')
                    ->label(__('dashboard.age_group_name_ar'))
                    ->sortable(),
                TextColumn::make('ageGroup.name_en')
                    ->label(__('dashboard.age_group_name_en'))
                    ->sortable(),
                TextColumn::make('gender')
                    ->label(__('dashboard.gender'))
                    ->badge()
                    ->color(function ($record) {
                        return $record->gender == 'male' ? 'info' : 'danger';
                    }),
                TextColumn::make('success_rate')
                    ->label(__('dashboard.success_rate'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('attemtps_count')
                    ->label(__('dashboard.attemtps_count'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('dashboard.status'))
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label(__('dashboard.updated_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('dashboard.deleted_at'))
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.subscriptions_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.packages');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.package');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.packages');
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
                TextInput::make('price')
                    ->label(__('dashboard.price'))
                    ->required()
                    ->numeric()
                    ->prefix('SAR'),
                TextInput::make('patiant_count')
                    ->label(__('dashboard.patiant_count'))
                    ->required()
                    ->numeric(),
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
                TextColumn::make('price')
                    ->label(__('dashboard.price'))
                    ->money()
                    ->sortable(),
                TextColumn::make('patiant_count')
                    ->label(__('dashboard.patiant_count'))
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}

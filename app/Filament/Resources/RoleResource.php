<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;


    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.users_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.roles');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.role');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.roles');
    }

    public static function canEdit($record): bool
    {
        return $record->name !== 'owner' && auth()->user()->hasPermission('role.update');
    }

    public static function canDelete($record): bool
    {
        return $record->name !== 'owner' && auth()->user()->hasPermission('role.delete');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('dashboard.role'))
                    ->required()
                    ->unique()
                    ->hiddenOn('edit')
                    ->maxLength(255),
                Select::make('permissions')
                    ->label(__('dashboard.permissions'))
                    ->relationship('permissions')
                    ->multiple()
                    ->live()
                    ->preload()
                    ->exists('permissions', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Permission $record) => "{$record->name} - {$record->name_ar}")
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('dashboard.id'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('dashboard.role'))
                    ->searchable(),
                TextColumn::make('permissions.name')
                    ->label(__('dashboard.permissions'))
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->limitList(10)
                    ->expandableLimitedList()
                    ->wrap()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}

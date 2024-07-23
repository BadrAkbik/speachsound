<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.users_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.permissions');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.permission');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.permissions');
    }

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('roles')
                    ->label(__('dashboard.roles'))
                    ->relationship('roles', 'id')
                    ->multiple()
                    ->live()
                    ->notIn(Role::firstWhere('name', 'owner')->id)
                    ->preload()
                    ->exists('roles', 'id')
                    ->options(Role::whereNot('name', 'owner')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
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
                    ->label(__('dashboard.permission'))
                    ->searchable(),
                TextColumn::make('name_ar')
                    ->label(__('dashboard.permission_ar'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('dashboard.role'))
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
            'index' => Pages\ListPermissions::route('/'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}

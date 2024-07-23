<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Role;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class UserResource extends Resource
{
    protected static ?string $model = User::class;


    public static function getNavigationBadgeTooltip(): ?string
    {
        return __('dashboard.The number of users');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.users_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.users');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.users');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canEdit($record): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $record->role->name !== 'owner' && $user->hasPermission('user.update');
    }

    public static function canDelete($record): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $record->role->name !== 'owner' && $user->hasPermission('user.delete');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('dashboard.name'))
                    ->minLength(2)->maxLength(15)->string()
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('dashboard.email'))
                    ->email()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label(__('dashboard.phone_number'))
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Select::make('role_id')
                    ->label(__('dashboard.role'))
                    ->relationship('role', 'id')
                    ->exists('roles', 'id')
                    ->notIn(Role::firstWhere('name', 'owner')->id)
                    ->live()
                    ->preload()
                    ->options(
                        function () {
                            return Role::whereNotIn('name', ['owner'])->pluck('name', 'id');
                        }
                    ),
                TextInput::make('password')
                    ->label(__('dashboard.password'))
                    ->password()
                    ->hiddenOn('edit')
                    ->required()
                    ->maxLength(255),
                Hidden::make('email_verified_at')->default(now()),
                ToggleButtons::make('type')
                    ->label(__('dashboard.type'))
                    ->inline()
                    ->options([
                        'personal' => __('dashboard.personal'),
                        'parent' => __('dashboard.parent'),
                        'specialist' => __('dashboard.specialist')
                    ])
                    ->colors([
                        'personal' => 'info',
                        'parent' => 'warning',
                        'specialist' => 'success',
                    ])
                    ->required(),
                FileUpload::make('image')
                    ->disk('public')
                    ->previewable(false)
                    ->directory('images')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('dashboard.id'))
                    ->sortable(),
                ImageColumn::make('image')
                    ->label(__('dashboard.image'))
                    ->circular(),
                TextColumn::make('type')
                    ->label(__('dashboard.type'))
                    ->badge()
                    ->color(function ($record) {
                        return $record->type == 'personal' ? 'info' : ($record->type == 'parent' ? 'danger' : ($record->type == 'specialist' ?? 'success'));
                    })
                    ->formatStateUsing(fn ($record) =>
                    $record->type == 'personal' ? __('dashboard.personal') : ($record->type == 'parent' ? __('dashboard.parent') : ($record->type == 'specialist' ?? __('dashboard.specialist')))),
                TextColumn::make('name')
                    ->label(__('dashboard.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('dashboard.email'))
                    ->searchable(),
                TextColumn::make('phone_num')
                    ->label(__('dashboard.phone_number'))
                    ->searchable(),
                TextColumn::make('role.name')
                    ->label(__('dashboard.role'))
                    ->badge()
                    ->color(function ($record) {
                        return $record->role->name == 'owner' ? 'danger' : 'warning';
                    })
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard.coupons_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.coupons');
    }

    public static function getModelLabel(): string
    {
        return __('dashboard.coupon');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard.coupons');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label(__('dashboard.code'))
                    ->required()
                    ->maxLength(255),
                DatePicker::make('start')
                    ->label(__('dashboard.start_date'))
                    ->required(),
                DatePicker::make('end')
                    ->label(__('dashboard.end_date'))
                    ->required(),
                TextInput::make('name_ar')
                    ->label(__('dashboard.name_ar'))
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('name_en')
                    ->label(__('dashboard.name_en'))
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('uses_limit')
                    ->label(__('dashboard.uses_limit'))
                    ->required()
                    ->numeric(),
                TextInput::make('uses_count')
                    ->label(__('dashboard.uses_count'))
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('type')
                    ->label(__('dashboard.type'))
                    ->options([
                        'percentage' => __('dashboard.percentage'),
                        'amount' => __('dashboard.amount')
                    ])
                    ->required(),
                TextInput::make('value')
                    ->label(__('dashboard.value'))
                    ->required()
                    ->numeric(),
                Toggle::make('active')
                    ->label(__('dashboard.active'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('dashboard.code'))
                    ->searchable(),
                TextColumn::make('start')
                    ->label(__('dashboard.start_date'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end')
                    ->label(__('dashboard.end_date'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label(__('dashboard.name_ar'))
                    ->searchable(),
                TextColumn::make('name_en')
                    ->label(__('dashboard.name_en'))
                    ->searchable(),
                IconColumn::make('active')
                    ->label(__('dashboard.active'))
                    ->boolean(),
                TextColumn::make('uses_limit')
                    ->label(__('dashboard.uses_limit'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('uses_count')
                    ->label(__('dashboard.uses_count'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('dashboard.type'))
                    ->formatStateUsing(function ($record) {
                        return $record->type == 'amount' ? __('dashboard.amount') : __('dashboard.percentage');
                    }),
                TextColumn::make('value')
                    ->label(__('dashboard.value'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('dashboard.updated_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}

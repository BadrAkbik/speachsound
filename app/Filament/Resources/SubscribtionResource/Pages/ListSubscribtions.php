<?php

namespace App\Filament\Resources\SubscribtionResource\Pages;

use App\Filament\Resources\SubscribtionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscribtions extends ListRecords
{
    protected static string $resource = SubscribtionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

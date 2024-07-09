<?php

namespace App\Filament\Resources\SubscribtionResource\Pages;

use App\Filament\Resources\SubscribtionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscribtion extends EditRecord
{
    protected static string $resource = SubscribtionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

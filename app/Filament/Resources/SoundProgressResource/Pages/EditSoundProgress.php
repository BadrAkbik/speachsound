<?php

namespace App\Filament\Resources\SoundProgressResource\Pages;

use App\Filament\Resources\SoundProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoundProgress extends EditRecord
{
    protected static string $resource = SoundProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

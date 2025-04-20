<?php

namespace App\Filament\Resources\SoundProgressResource\Pages;

use App\Filament\Resources\SoundProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSoundProgress extends CreateRecord
{
    protected static string $resource = SoundProgressResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

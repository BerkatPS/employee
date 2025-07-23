<?php

namespace App\Filament\Resources\EncryptedDataResource\Pages;

use App\Filament\Resources\EncryptedDataResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEncryptedData extends CreateRecord
{
    protected static string $resource = EncryptedDataResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
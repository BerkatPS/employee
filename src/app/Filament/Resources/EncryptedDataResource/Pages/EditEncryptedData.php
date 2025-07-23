<?php

namespace App\Filament\Resources\EncryptedDataResource\Pages;

use App\Filament\Resources\EncryptedDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEncryptedData extends EditRecord
{
    protected static string $resource = EncryptedDataResource::class;

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
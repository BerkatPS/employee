<?php

namespace App\Filament\Resources\EncryptedDataResource\Pages;

use App\Filament\Resources\EncryptedDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEncryptedData extends ListRecords
{
    protected static string $resource = EncryptedDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
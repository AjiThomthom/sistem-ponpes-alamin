<?php

namespace App\Filament\Resources\MstAsatidzResource\Pages;

use App\Filament\Resources\MstAsatidzResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMstAsatidz extends CreateRecord
{
    protected static string $resource = MstAsatidzResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Asatidz baru berhasil ditambahkan! 👨‍🏫';
    }
}

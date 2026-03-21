<?php

namespace App\Filament\Resources\MstSantriResource\Pages;

use App\Filament\Resources\MstSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMstSantri extends CreateRecord
{
    protected static string $resource = MstSantriResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Sip! Data Santri baru berhasil ditambahkan 🎓';
    }
}

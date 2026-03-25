<?php

namespace App\Filament\Resources\CmsJadwalPengajianResource\Pages;

use App\Filament\Resources\CmsJadwalPengajianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCmsJadwalPengajian extends CreateRecord
{
    protected static string $resource = CmsJadwalPengajianResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Jadwal baru berhasil ditambahkan! 📅';
    }
}

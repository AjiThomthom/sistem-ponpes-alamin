<?php

namespace App\Filament\Resources\CmsJadwalPengajianResource\Pages;

use App\Filament\Resources\CmsJadwalPengajianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsJadwalPengajian extends EditRecord
{
    protected static string $resource = CmsJadwalPengajianResource::class;

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

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data Jadwal berhasil diupdate! ✨';
    }
}

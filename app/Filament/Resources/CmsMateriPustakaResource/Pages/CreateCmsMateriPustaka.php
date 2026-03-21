<?php

namespace App\Filament\Resources\CmsMateriPustakaResource\Pages;

use App\Filament\Resources\CmsMateriPustakaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCmsMateriPustaka extends CreateRecord
{
    protected static string $resource = CmsMateriPustakaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mantap! Materi berhasil diterbitkan 🚀';
    }
}

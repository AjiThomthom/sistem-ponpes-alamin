<?php

namespace App\Filament\Resources\MstSantriResource\Pages;

use App\Filament\Resources\MstSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstSantri extends EditRecord
{
    protected static string $resource = MstSantriResource::class;

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
        return 'Data Santri berhasil diupdate! ✨';
    }
}

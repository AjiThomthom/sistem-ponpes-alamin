<?php

namespace App\Filament\Resources\MstAsatidzResource\Pages;

use App\Filament\Resources\MstAsatidzResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstAsatidz extends EditRecord
{
    protected static string $resource = MstAsatidzResource::class;

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
        return 'Data Asatidz berhasil diupdate! ✨';
    }
}

<?php

namespace App\Filament\Resources\TrxBukuKasResource\Pages;

use App\Filament\Resources\TrxBukuKasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrxBukuKas extends EditRecord
{
    protected static string $resource = TrxBukuKasResource::class;

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
        return 'Data Kas berhasil diupdate! 📝';
    }
}

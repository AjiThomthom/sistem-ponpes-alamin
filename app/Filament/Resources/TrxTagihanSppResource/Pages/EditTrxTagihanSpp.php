<?php

namespace App\Filament\Resources\TrxTagihanSppResource\Pages;

use App\Filament\Resources\TrxTagihanSppResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrxTagihanSpp extends EditRecord
{
    protected static string $resource = TrxTagihanSppResource::class;

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
        return 'Status Tagihan berhasil diperbarui! ✅';
    }
}

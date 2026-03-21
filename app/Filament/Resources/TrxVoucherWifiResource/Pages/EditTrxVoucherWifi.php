<?php

namespace App\Filament\Resources\TrxVoucherWifiResource\Pages;

use App\Filament\Resources\TrxVoucherWifiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrxVoucherWifi extends EditRecord
{
    protected static string $resource = TrxVoucherWifiResource::class;

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
        return 'Data Voucher berhasil diupdate! ✨';
    }
}

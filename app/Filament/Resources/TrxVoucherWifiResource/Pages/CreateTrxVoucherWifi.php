<?php

namespace App\Filament\Resources\TrxVoucherWifiResource\Pages;

use App\Filament\Resources\TrxVoucherWifiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrxVoucherWifi extends CreateRecord
{
    protected static string $resource = TrxVoucherWifiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Sip! Voucher Wi-Fi berhasil di-generate 📶';
    }
}

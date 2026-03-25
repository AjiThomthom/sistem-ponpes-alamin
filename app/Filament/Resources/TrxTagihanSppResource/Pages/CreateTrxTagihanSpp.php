<?php

namespace App\Filament\Resources\TrxTagihanSppResource\Pages;

use App\Filament\Resources\TrxTagihanSppResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrxTagihanSpp extends CreateRecord
{
    protected static string $resource = TrxTagihanSppResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Tagihan SPP berhasil dicatat! 💸';
    }
}

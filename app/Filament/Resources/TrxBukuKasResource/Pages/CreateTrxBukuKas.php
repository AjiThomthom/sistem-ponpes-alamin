<?php

namespace App\Filament\Resources\TrxBukuKasResource\Pages;

use App\Filament\Resources\TrxBukuKasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrxBukuKas extends CreateRecord
{
    protected static string $resource = TrxBukuKasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Sip! Transaksi Kas berhasil dicatat 💰';
    }
}

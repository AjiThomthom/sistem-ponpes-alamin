<?php

namespace App\Filament\Resources\TrxVoucherWifiResource\Pages;

use App\Filament\Resources\TrxVoucherWifiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrxVoucherWifis extends ListRecords
{
    protected static string $resource = TrxVoucherWifiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

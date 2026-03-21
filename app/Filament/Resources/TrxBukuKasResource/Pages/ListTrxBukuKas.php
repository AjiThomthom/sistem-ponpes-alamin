<?php

namespace App\Filament\Resources\TrxBukuKasResource\Pages;

use App\Filament\Resources\TrxBukuKasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrxBukuKas extends ListRecords
{
    protected static string $resource = TrxBukuKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

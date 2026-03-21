<?php

namespace App\Filament\Resources\TrxTagihanSppResource\Pages;

use App\Filament\Resources\TrxTagihanSppResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrxTagihanSpps extends ListRecords
{
    protected static string $resource = TrxTagihanSppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

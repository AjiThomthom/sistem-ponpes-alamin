<?php

namespace App\Filament\Resources\MstAsatidzResource\Pages;

use App\Filament\Resources\MstAsatidzResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstAsatidzs extends ListRecords
{
    protected static string $resource = MstAsatidzResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

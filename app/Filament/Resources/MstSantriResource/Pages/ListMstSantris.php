<?php

namespace App\Filament\Resources\MstSantriResource\Pages;

use App\Filament\Resources\MstSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstSantris extends ListRecords
{
    protected static string $resource = MstSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

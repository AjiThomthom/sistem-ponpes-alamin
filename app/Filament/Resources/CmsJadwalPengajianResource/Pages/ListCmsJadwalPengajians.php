<?php

namespace App\Filament\Resources\CmsJadwalPengajianResource\Pages;

use App\Filament\Resources\CmsJadwalPengajianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCmsJadwalPengajians extends ListRecords
{
    protected static string $resource = CmsJadwalPengajianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\CmsMateriPustakaResource\Pages;

use App\Filament\Resources\CmsMateriPustakaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsMateriPustaka extends EditRecord
{
    protected static string $resource = CmsMateriPustakaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

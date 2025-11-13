<?php

namespace App\Filament\Resources\BajuPengantin\Pages;

use App\Filament\Resources\BajuPengantin\BajuPengantinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBajuPengantin extends ListRecords
{
    protected static string $resource = BajuPengantinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

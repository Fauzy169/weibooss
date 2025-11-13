<?php

namespace App\Filament\Resources\Aksesoris\Pages;

use App\Filament\Resources\Aksesoris\AksesorisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAksesoris extends ListRecords
{
    protected static string $resource = AksesorisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

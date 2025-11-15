<?php

namespace App\Filament\Resources\Warehouse\ProcurementResource\Pages;

use App\Filament\Resources\Warehouse\ProcurementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcurements extends ListRecords
{
    protected static string $resource = ProcurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pengadaan')
                ->icon('heroicon-o-plus'),
        ];
    }
}

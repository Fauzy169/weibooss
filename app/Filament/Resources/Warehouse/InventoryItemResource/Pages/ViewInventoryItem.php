<?php

namespace App\Filament\Resources\Warehouse\InventoryItemResource\Pages;

use App\Filament\Resources\Warehouse\InventoryItemResource;
use App\Models\StockMovement;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewInventoryItem extends ViewRecord
{
    protected static string $resource = InventoryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Edit Data'),
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }
}

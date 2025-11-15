<?php

namespace App\Filament\Resources\Warehouse\ProcurementResource\Pages;

use App\Filament\Resources\Warehouse\ProcurementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcurement extends EditRecord
{
    protected static string $resource = ProcurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Recalculate total_cost after items are saved
        $record = $this->getRecord();
        $totalCost = 0;
        
        if ($record->items) {
            foreach ($record->items as $item) {
                $qty = (int) ($item->qty ?? 0);
                $unitCost = (float) ($item->unit_cost ?? 0);
                $totalCost += $qty * $unitCost;
            }
        }
        
        $record->update(['total_cost' => $totalCost]);
    }
}

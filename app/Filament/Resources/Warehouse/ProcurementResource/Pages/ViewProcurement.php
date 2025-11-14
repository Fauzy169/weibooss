<?php

namespace App\Filament\Resources\Warehouse\ProcurementResource\Pages;

use App\Filament\Resources\Warehouse\ProcurementResource;
use App\Models\Procurement;
use App\Models\StockMovement;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewProcurement extends ViewRecord
{
    protected static string $resource = ProcurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('request')
                ->label('Ajukan')
                ->color('warning')
                ->visible(fn (Procurement $record) => $record->status === 'draft')
                ->action(function (Procurement $record) {
                    $record->update(['status' => 'requested', 'requested_at' => now()]);
                }),
            Action::make('approve')
                ->label('Setujui')
                ->color('info')
                ->visible(fn (Procurement $record) => $record->status === 'requested')
                ->action(function (Procurement $record) {
                    $record->update(['status' => 'approved', 'approved_at' => now()]);
                }),
            Action::make('receive')
                ->label('Terima Barang')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Procurement $record) => in_array($record->status, ['approved', 'requested']))
                ->action(function (Procurement $record) {
                    foreach ($record->items as $item) {
                        $inv = $item->inventoryItem;
                        if ($inv) {
                            $inv->update(['current_stock' => $inv->current_stock + (int) $item->qty]);
                            StockMovement::create([
                                'inventory_item_id' => $inv->id,
                                'type' => 'in',
                                'quantity' => (int) $item->qty,
                                'reason' => 'Procurement received ' . $record->code,
                            ]);
                        }
                    }
                    $record->update(['status' => 'received', 'received_at' => now()]);
                }),
            Action::make('cancel')
                ->label('Batalkan')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Procurement $record) => $record->status !== 'received' && $record->status !== 'canceled')
                ->action(function (Procurement $record) {
                    $record->update(['status' => 'canceled']);
                }),
        ];
    }
}

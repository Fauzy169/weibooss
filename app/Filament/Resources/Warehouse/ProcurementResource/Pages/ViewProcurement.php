<?php

namespace App\Filament\Resources\Warehouse\ProcurementResource\Pages;

use App\Filament\Resources\Warehouse\ProcurementResource;
use App\Models\Procurement;
use App\Models\StockMovement;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewProcurement extends ViewRecord
{
    protected static string $resource = ProcurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make()
                ->label('Edit Data')
                ->visible(fn (Procurement $record) => $record->status === 'draft'),
            Action::make('request')
                ->label('Ajukan')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->visible(fn (Procurement $record) => $record->status === 'draft')
                ->requiresConfirmation()
                ->modalHeading('Ajukan Pengadaan?')
                ->modalDescription('Pengadaan ini akan diajukan ke bagian keuangan untuk disetujui.')
                ->action(function (Procurement $record) {
                    $record->update(['status' => 'requested', 'requested_at' => now()]);
                })
                ->successNotificationTitle('Pengadaan berhasil diajukan ke bagian keuangan'),
            Action::make('receive')
                ->label('Terima Barang')
                ->icon('heroicon-o-inbox-arrow-down')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Terima Barang Pengadaan?')
                ->modalDescription('Barang akan ditambahkan ke stok dan pengadaan akan selesai.')
                ->visible(fn (Procurement $record) => $record->status === 'approved')
                ->action(function (Procurement $record) {
                    foreach ($record->items as $item) {
                        $inv = $item->inventoryItem;
                        if ($inv) {
                            $inv->update(['current_stock' => $inv->current_stock + (int) $item->qty]);
                            StockMovement::create([
                                'inventory_item_id' => $inv->id,
                                'type' => 'in',
                                'quantity' => (int) $item->qty,
                                'reason' => 'Pengadaan diterima - ' . $record->code,
                                'user_id' => Auth::id(),
                            ]);
                        }
                    }
                    $record->update(['status' => 'received', 'received_at' => now()]);
                })
                ->successNotificationTitle('Barang berhasil diterima dan stok telah diperbarui'),
            Action::make('cancel')
                ->label('Batalkan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Batalkan Pengadaan?')
                ->modalDescription('Pengadaan ini akan dibatalkan dan tidak dapat diproses lagi.')
                ->visible(fn (Procurement $record) => !in_array($record->status, ['received', 'canceled']))
                ->action(function (Procurement $record) {
                    $record->update(['status' => 'canceled']);
                })
                ->successNotificationTitle('Pengadaan berhasil dibatalkan'),
            \Filament\Actions\DeleteAction::make()
                ->label('Hapus')
                ->visible(fn (Procurement $record) => in_array($record->status, ['draft', 'canceled'])),
        ];
    }
}

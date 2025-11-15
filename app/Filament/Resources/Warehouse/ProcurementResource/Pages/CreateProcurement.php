<?php

namespace App\Filament\Resources\Warehouse\ProcurementResource\Pages;

use App\Filament\Resources\Warehouse\ProcurementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProcurement extends CreateRecord
{
    protected static string $resource = ProcurementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['requested_at'] = now();
        $data['total_cost'] = 0; // Will be updated after items are saved
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Calculate total_cost after items are saved
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

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pengadaan berhasil dibuat';
    }
    
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCreateAnotherFormAction(),
            \Filament\Actions\Action::make('createAndSubmit')
                ->label('Buat & Ajukan')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->action('createAndSubmit'),
            $this->getCancelFormAction(),
        ];
    }
    
    public function createAndSubmit(): void
    {
        $this->create();
        
        $record = $this->getRecord();
        $record->update([
            'status' => 'requested',
            'requested_at' => now(),
        ]);
        
        $this->redirect($this->getResource()::getUrl('view', ['record' => $record]));
    }
}

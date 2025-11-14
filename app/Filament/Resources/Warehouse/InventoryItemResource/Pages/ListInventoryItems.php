<?php

namespace App\Filament\Resources\Warehouse\InventoryItemResource\Pages;

use App\Filament\Resources\Warehouse\InventoryItemResource;
use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListInventoryItems extends ListRecords
{
    protected static string $resource = InventoryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('syncFromCatalog')
                ->label('Sinkron Katalog')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $created = 0; $updated = 0;

                    $sync = function (string $type, int $id, array $data) use (&$created, &$updated) {
                        $item = InventoryItem::where('item_type', $type)->where('item_id', $id)->first();
                        if ($item) {
                            $item->fill($data);
                            if ($item->isDirty()) { $item->save(); $updated++; }
                        } else {
                            InventoryItem::create(array_merge(['item_type' => $type, 'item_id' => $id], $data));
                            $created++;
                        }
                    };

                    // Products
                    foreach (Product::query()->get(['id','name','slug','price']) as $p) {
                        $sync(Product::class, $p->id, [
                            'name' => $p->name,
                            'sku' => $p->slug,
                            'unit' => 'pcs',
                            'cost' => (float) ($p->price ?? 0),
                            'is_active' => true,
                        ]);
                    }

                    // Services (optional stock tracking)
                    foreach (Service::query()->get(['id','name','slug','price']) as $s) {
                        $sync(Service::class, $s->id, [
                            'name' => $s->name,
                            'sku' => $s->slug ?? ('svc-'.$s->id),
                            'unit' => 'pcs',
                            'cost' => (float) ($s->price ?? 0),
                            'is_active' => true,
                        ]);
                    }

                    Notification::make()
                        ->title('Sinkronisasi selesai')
                        ->body("Dibuat: {$created}, Diperbarui: {$updated}")
                        ->success()
                        ->send();
                }),
        ];
    }
}

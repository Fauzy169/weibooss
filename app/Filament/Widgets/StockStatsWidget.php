<?php

namespace App\Filament\Widgets;

use App\Models\InventoryItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StockStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalItems = InventoryItem::count();
        $lowStock = InventoryItem::whereRaw('current_stock <= min_stock')->count();
        $totalValue = InventoryItem::get()->sum(fn ($item) => $item->current_stock * $item->cost);
        $activeItems = InventoryItem::where('is_active', true)->count();

        return [
            Stat::make('Total Item', number_format($totalItems, 0, ',', '.'))
                ->description('Total jenis barang/bahan')
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary'),
            
            Stat::make('Stok Menipis', number_format($lowStock, 0, ',', '.'))
                ->description('Item dengan stok dibawah minimum')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($lowStock > 0 ? 'danger' : 'success'),
            
            Stat::make('Nilai Total Stok', 'Rp ' . number_format($totalValue, 0, ',', '.'))
                ->description('Total nilai inventori')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
            
            Stat::make('Item Aktif', number_format($activeItems, 0, ',', '.'))
                ->description('Item yang tersedia')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('info'),
        ];
    }
}

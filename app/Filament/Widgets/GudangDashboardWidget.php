<?php

namespace App\Filament\Widgets;

use App\Models\InventoryItem;
use App\Models\Procurement;
use App\Models\StockMovement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class GudangDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->isGudang();
    }

    protected function getStats(): array
    {
        // Inventory Stats
        $totalItems = InventoryItem::count();
        $lowStock = InventoryItem::whereRaw('current_stock <= min_stock')->count();
        $outOfStock = InventoryItem::where('current_stock', 0)->count();
        $totalValue = InventoryItem::get()->sum(fn ($item) => $item->current_stock * $item->cost);
        
        // Procurement Stats
        $pendingProcurement = Procurement::where('status', 'requested')->count();
        $approvedProcurement = Procurement::where('status', 'approved')->count();
        
        // Stock Movement Today
        $movementsToday = StockMovement::whereDate('created_at', today())->count();
        
        return [
            Stat::make('📦 Total Item', $totalItems)
                ->description('Jenis barang/bahan')
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary'),
            
            Stat::make('⚠️ Stok Menipis', $lowStock)
                ->description('Perlu segera restock')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($lowStock > 0 ? 'danger' : 'success'),
            
            Stat::make('🚨 Stok Habis', $outOfStock)
                ->description('Item dengan stok 0')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color($outOfStock > 0 ? 'danger' : 'success'),
            
            Stat::make('💰 Nilai Total Stok', 'Rp ' . number_format($totalValue, 0, ',', '.'))
                ->description('Total nilai inventori')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
            
            Stat::make('📝 Pengadaan Pending', $pendingProcurement)
                ->description('Menunggu persetujuan')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingProcurement > 0 ? 'warning' : 'success'),
            
            Stat::make('✅ Pengadaan Approved', $approvedProcurement)
                ->description('Siap diterima')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('info'),
        ];
    }
}

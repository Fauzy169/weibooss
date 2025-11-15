<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class KasirDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->isKasir();
    }

    protected function getStats(): array
    {
        // Order hari ini
        $ordersToday = Order::whereDate('placed_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedToday = Order::where('status', 'completed')->whereDate('updated_at', today())->count();
        
        // Transaksi
        $totalToday = Order::whereDate('placed_at', today())->sum('total');
        $paidToday = Order::where('status', 'paid')->whereDate('placed_at', today())->count();
        
        return [
            Stat::make('🛒 Order Hari Ini', $ordersToday)
                ->description('Total pesanan masuk')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('primary'),
            
            Stat::make('⏳ Pending', $pendingOrders)
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
            
            Stat::make('⚙️ Diproses', $processingOrders)
                ->description('Sedang dikerjakan')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('info'),
            
            Stat::make('✅ Selesai Hari Ini', $completedToday)
                ->description('Order completed')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            
            Stat::make('💰 Transaksi Hari Ini', 'Rp ' . number_format($totalToday, 0, ',', '.'))
                ->description('Total nilai order')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
            
            Stat::make('✔️ Terbayar', $paidToday)
                ->description('Order paid hari ini')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success'),
        ];
    }
}

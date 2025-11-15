<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\Promotion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SalesDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->isSales();
    }

    protected function getStats(): array
    {
        // Produk
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        
        // Services
        $totalServices = Service::count();
        $activeServices = Service::where('is_active', true)->count();
        
        // Promotions
        $activePromotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();
        
        // Sales Data
        $ordersToday = Order::whereDate('placed_at', today())->count();
        $salesMonth = Order::where('status', 'paid')
            ->whereMonth('placed_at', now()->month)
            ->whereYear('placed_at', now()->year)
            ->sum('total');
        
        return [
            Stat::make('🛍️ Order Hari Ini', $ordersToday)
                ->description('Pesanan masuk hari ini')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('success'),
            
            Stat::make('💰 Penjualan Bulan Ini', 'Rp ' . number_format($salesMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary'),
            
            Stat::make('👗 Produk Aktif', $activeProducts . ' / ' . $totalProducts)
                ->description('Baju Pengantin & Aksesoris')
                ->descriptionIcon('heroicon-o-sparkles')
                ->color('info'),
            
            Stat::make('✨ Service Aktif', $activeServices . ' / ' . $totalServices)
                ->description('Layanan tersedia')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('success'),
            
            Stat::make('🎁 Promosi Aktif', $activePromotions)
                ->description('Promosi berjalan')
                ->descriptionIcon('heroicon-o-tag')
                ->color('warning'),
            
            Stat::make('📊 Konversi', '0%')
                ->description('Coming soon')
                ->descriptionIcon('heroicon-o-chart-pie')
                ->color('gray'),
        ];
    }
}

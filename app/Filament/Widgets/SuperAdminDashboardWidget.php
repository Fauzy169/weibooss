<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Expense;
use App\Models\User;
use App\Models\Product;
use App\Models\InventoryItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SuperAdminDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->isSuperAdmin();
    }

    protected function getStats(): array
    {
        // Financial Overview
        $incomeToday = Order::where('status', 'paid')->whereDate('placed_at', today())->sum('total');
        $incomeMonth = Order::where('status', 'paid')
            ->whereMonth('placed_at', now()->month)
            ->whereYear('placed_at', now()->year)
            ->sum('total');
        $expenseMonth = Expense::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount');
        $profitMonth = $incomeMonth - $expenseMonth;
        
        // Operations
        $pendingOrders = Order::whereIn('status', ['pending', 'processing'])->count();
        $lowStock = InventoryItem::whereRaw('current_stock <= min_stock')->count();
        
        // Users
        $totalUsers = User::count();
        $newUsersMonth = User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        
        // Products
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        
        return [
            Stat::make('💰 Profit Bulan Ini', 'Rp ' . number_format($profitMonth, 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran ' . now()->format('F'))
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color($profitMonth >= 0 ? 'success' : 'danger')
                ->chart([
                    $incomeMonth / 1000000,
                    $expenseMonth / 1000000,
                    $profitMonth / 1000000
                ]),
            
            Stat::make('💵 Pemasukan Hari Ini', 'Rp ' . number_format($incomeToday, 0, ',', '.'))
                ->description('Total penjualan terbayar')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),
            
            Stat::make('📊 Pemasukan Bulan Ini', 'Rp ' . number_format($incomeMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary'),
            
            Stat::make('📦 Order Pending', $pendingOrders)
                ->description('Menunggu diproses')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),
            
            Stat::make('⚠️ Stok Menipis', $lowStock)
                ->description('Item perlu restock')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($lowStock > 0 ? 'danger' : 'success'),
            
            Stat::make('👥 Total Users', $totalUsers)
                ->description($newUsersMonth . ' baru bulan ini')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
            
            Stat::make('🛍️ Produk', $activeProducts . ' / ' . $totalProducts)
                ->description('Aktif / Total')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('primary'),
            
            Stat::make('💸 Pengeluaran Bulan Ini', 'Rp ' . number_format($expenseMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('warning'),
        ];
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Expense;
use App\Models\InventoryItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'owner']);
    }

    protected function getStats(): array
    {
        // Pemasukan
        $incomeToday = Order::where('status', 'paid')->whereDate('placed_at', today())->sum('total');
        $incomeMonth = Order::where('status', 'paid')->whereMonth('placed_at', now()->month)->whereYear('placed_at', now()->year)->sum('total');
        
        // Pengeluaran
        $expenseToday = Expense::whereDate('date', today())->sum('amount');
        $expenseMonth = Expense::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount');
        
        // Profit
        $profitToday = $incomeToday - $expenseToday;
        $profitMonth = $incomeMonth - $expenseMonth;
        
        // Stok & Order
        $lowStock = InventoryItem::whereRaw('current_stock <= min_stock')->count();
        $pendingOrders = Order::whereIn('status', ['pending', 'processing'])->count();
        
        return [
            Stat::make('💰 Profit Hari Ini', 'Rp ' . number_format($profitToday, 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color($profitToday >= 0 ? 'success' : 'danger')
                ->chart([$incomeToday, $expenseToday]),
            
            Stat::make('📊 Profit Bulan Ini', 'Rp ' . number_format($profitMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color($profitMonth >= 0 ? 'success' : 'danger'),
            
            Stat::make('💵 Pemasukan Bulan Ini', 'Rp ' . number_format($incomeMonth, 0, ',', '.'))
                ->description('Total order terbayar')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),
            
            Stat::make('💸 Pengeluaran Bulan Ini', 'Rp ' . number_format($expenseMonth, 0, ',', '.'))
                ->description('Total biaya operasional')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('warning'),
            
            Stat::make('⚠️ Stok Menipis', $lowStock)
                ->description('Item perlu restock')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($lowStock > 0 ? 'danger' : 'success'),
            
            Stat::make('📦 Order Pending', $pendingOrders)
                ->description('Menunggu proses')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),
        ];
    }
}

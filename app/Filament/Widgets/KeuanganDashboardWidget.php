<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class KeuanganDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->isKeuangan();
    }

    protected function getStats(): array
    {
        // Pemasukan
        $incomeToday = Order::where('status', 'paid')->whereDate('placed_at', today())->sum('total');
        $incomeMonth = Order::where('status', 'paid')
            ->whereMonth('placed_at', now()->month)
            ->whereYear('placed_at', now()->year)
            ->sum('total');
        $incomeYear = Order::where('status', 'paid')->whereYear('placed_at', now()->year)->sum('total');
        
        // Pengeluaran
        $expenseToday = Expense::whereDate('date', today())->sum('amount');
        $expenseMonth = Expense::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount');
        $expenseYear = Expense::whereYear('date', now()->year)->sum('amount');
        
        // Saldo
        $balanceMonth = $incomeMonth - $expenseMonth;
        
        return [
            Stat::make('💵 Pemasukan Hari Ini', 'Rp ' . number_format($incomeToday, 0, ',', '.'))
                ->description('Order terbayar')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),
            
            Stat::make('💸 Pengeluaran Hari Ini', 'Rp ' . number_format($expenseToday, 0, ',', '.'))
                ->description('Total pengeluaran')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('danger'),
            
            Stat::make('📊 Pemasukan Bulan Ini', 'Rp ' . number_format($incomeMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary'),
            
            Stat::make('📉 Pengeluaran Bulan Ini', 'Rp ' . number_format($expenseMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-document-minus')
                ->color('warning'),
            
            Stat::make('💰 Saldo Bulan Ini', 'Rp ' . number_format($balanceMonth, 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran')
                ->descriptionIcon('heroicon-o-calculator')
                ->color($balanceMonth >= 0 ? 'success' : 'danger'),
            
            Stat::make('📈 Pemasukan Tahun Ini', 'Rp ' . number_format($incomeYear, 0, ',', '.'))
                ->description(now()->format('Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}

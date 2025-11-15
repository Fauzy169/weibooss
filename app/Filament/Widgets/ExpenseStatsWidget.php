<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpenseStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Expense::whereDate('date', today())->sum('amount');
        $thisMonth = Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        $thisYear = Expense::whereYear('date', now()->year)->sum('amount');
        $totalExpenses = Expense::count();

        return [
            Stat::make('Pengeluaran Hari Ini', 'Rp ' . number_format($today, 0, ',', '.'))
                ->description('Total pengeluaran hari ini')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('danger'),
            
            Stat::make('Pengeluaran Bulan Ini', 'Rp ' . number_format($thisMonth, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning'),
            
            Stat::make('Pengeluaran Tahun Ini', 'Rp ' . number_format($thisYear, 0, ',', '.'))
                ->description(now()->format('Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary'),
            
            Stat::make('Total Transaksi', number_format($totalExpenses, 0, ',', '.'))
                ->description('Total transaksi pengeluaran')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info'),
        ];
    }
}

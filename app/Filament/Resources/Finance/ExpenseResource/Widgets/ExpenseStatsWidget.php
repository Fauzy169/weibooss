<?php

namespace App\Filament\Resources\Finance\ExpenseResource\Widgets;

use App\Models\Expense;
use App\Models\Procurement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpenseStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        
        // Total pengeluaran bulan ini
        $totalThisMonth = Expense::whereDate('date', '>=', $thisMonth)->sum('amount');
        $totalLastMonth = Expense::whereDate('date', '>=', $lastMonth)
            ->whereDate('date', '<', $thisMonth)
            ->sum('amount');
        
        $percentChange = $totalLastMonth > 0 
            ? (($totalThisMonth - $totalLastMonth) / $totalLastMonth) * 100 
            : 0;
        
        // Pengeluaran dari pengadaan
        $procurementExpenses = Expense::whereNotNull('procurement_id')
            ->whereDate('date', '>=', $thisMonth)
            ->sum('amount');
        
        // Pengeluaran manual
        $manualExpenses = Expense::whereNull('procurement_id')
            ->whereDate('date', '>=', $thisMonth)
            ->sum('amount');
        
        // Pengadaan pending
        $pendingProcurements = Procurement::where('status', 'requested')->count();
        $pendingAmount = Procurement::where('status', 'requested')
            ->get()
            ->sum(fn ($p) => $p->items->sum('subtotal'));
        
        return [
            Stat::make('Total Pengeluaran Bulan Ini', 'Rp ' . number_format($totalThisMonth, 0, ',', '.'))
                ->description($percentChange >= 0 
                    ? '+' . number_format(abs($percentChange), 1) . '% dari bulan lalu'
                    : '-' . number_format(abs($percentChange), 1) . '% dari bulan lalu')
                ->descriptionIcon($percentChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($percentChange >= 0 ? 'danger' : 'success')
                ->chart([
                    $totalLastMonth / 1000000,
                    $totalThisMonth / 1000000,
                ]),
            
            Stat::make('Pengeluaran dari Pengadaan', 'Rp ' . number_format($procurementExpenses, 0, ',', '.'))
                ->description('Dari pengadaan yang disetujui')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
            
            Stat::make('Pengeluaran Manual', 'Rp ' . number_format($manualExpenses, 0, ',', '.'))
                ->description('Pengeluaran di luar pengadaan')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('success'),
            
            Stat::make('Pengajuan Pengadaan Pending', $pendingProcurements)
                ->description('Estimasi: Rp ' . number_format($pendingAmount, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingProcurements > 0 ? 'warning' : 'success')
                ->url($pendingProcurements > 0 
                    ? \App\Filament\Resources\Finance\ExpenseResource::getUrl('procurements')
                    : null),
        ];
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
}

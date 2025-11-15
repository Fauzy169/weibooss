<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class IncomeStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Order::where('status', 'paid')
            ->whereDate('placed_at', today())
            ->sum('total');
        $thisMonth = Order::where('status', 'paid')
            ->whereMonth('placed_at', now()->month)
            ->whereYear('placed_at', now()->year)
            ->sum('total');
        $thisYear = Order::where('status', 'paid')
            ->whereYear('placed_at', now()->year)
            ->sum('total');
        $totalOrders = Order::where('status', 'paid')->count();

        return [
            Stat::make('Pemasukan Hari Ini', 'Rp ' . number_format($today, 0, ',', '.'))
                ->description('Order terbayar hari ini')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success'),
            
            Stat::make('Pemasukan Bulan Ini', 'Rp ' . number_format($thisMonth, 0, ',', '.'))
                ->description('Terbayar ' . now()->format('F Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('primary'),
            
            Stat::make('Pemasukan Tahun Ini', 'Rp ' . number_format($thisYear, 0, ',', '.'))
                ->description('Terbayar ' . now()->format('Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('warning'),
            
            Stat::make('Total Order Terbayar', number_format($totalOrders, 0, ',', '.'))
                ->description('Order dengan status paid')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('info'),
        ];
    }
}

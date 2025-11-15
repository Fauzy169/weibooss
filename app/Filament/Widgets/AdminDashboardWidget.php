<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdminDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->isAdministrator();
    }

    protected function getStats(): array
    {
        // User Stats
        $totalUsers = User::count();
        $newUsersToday = User::whereDate('created_at', today())->count();
        $customerCount = User::where('role', 'customer')->count();
        $staffCount = User::whereIn('role', ['administrator', 'sales', 'kasir', 'keuangan', 'gudang', 'owner'])->count();
        
        // System Stats
        $totalBrands = Brand::count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        
        return [
            Stat::make('👥 Total Users', $totalUsers)
                ->description('Semua pengguna')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            
            Stat::make('🆕 User Baru Hari Ini', $newUsersToday)
                ->description('Registrasi hari ini')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('success'),
            
            Stat::make('👤 Customer', $customerCount)
                ->description('Total pelanggan')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),
            
            Stat::make('👔 Staff', $staffCount)
                ->description('Admin & Staff')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('warning'),
            
            Stat::make('🏷️ Brands', $totalBrands)
                ->description('Total merek')
                ->descriptionIcon('heroicon-o-tag')
                ->color('success'),
            
            Stat::make('📂 Categories', $totalCategories)
                ->description('Total kategori')
                ->descriptionIcon('heroicon-o-folder')
                ->color('primary'),
        ];
    }
}

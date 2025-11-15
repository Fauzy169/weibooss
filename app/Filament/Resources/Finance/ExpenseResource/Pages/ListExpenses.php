<?php

namespace App\Filament\Resources\Finance\ExpenseResource\Pages;

use App\Filament\Resources\Finance\ExpenseResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        $pendingCount = \App\Models\Procurement::where('status', 'requested')->count();
        
        return [
            Actions\Action::make('manage_procurements')
                ->label('Kelola Pengajuan Pengadaan')
                ->icon('heroicon-o-clipboard-document-check')
                ->color('warning')
                ->url(fn () => ExpenseResource::getUrl('procurements'))
                ->badge($pendingCount > 0 ? $pendingCount : null)
                ->badgeColor('danger')
                ->visible(fn () => $pendingCount > 0)
                ->tooltip('Ada ' . $pendingCount . ' pengajuan pengadaan menunggu persetujuan'),
            Actions\CreateAction::make()
                ->label('Tambah Pengeluaran Manual')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->tooltip('Tambah pengeluaran di luar pengadaan'),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\Finance\ExpenseResource\Widgets\ExpenseStatsWidget::class,
        ];
    }
}

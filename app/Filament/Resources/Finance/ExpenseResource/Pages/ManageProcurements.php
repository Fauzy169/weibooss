<?php

namespace App\Filament\Resources\Finance\ExpenseResource\Pages;

use App\Filament\Resources\Finance\ExpenseResource;
use App\Models\Procurement;
use App\Models\Expense;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class ManageProcurements extends ManageRecords
{
    protected static string $resource = ExpenseResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Kelola Pengajuan Pengadaan';
    }

    public function getTitle(): string
    {
        return 'Kelola Pengajuan Pengadaan';
    }
    
    public function getHeading(): string
    {
        return 'Kelola Pengajuan Pengadaan';
    }
    
    public function getSubheading(): ?string
    {
        $count = Procurement::where('status', 'requested')->count();
        $procurements = Procurement::with('items')->where('status', 'requested')->get();
        $total = $procurements->sum(function ($p) {
            return $p->items->sum(function ($item) {
                return $item->qty * $item->unit_cost;
            });
        });
        
        if ($count > 0) {
            return $count . ' pengajuan menunggu persetujuan dengan total estimasi Rp ' . number_format($total, 0, ',', '.');
        }
        
        return 'Semua pengajuan pengadaan sudah diproses.';
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Pengeluaran')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(ExpenseResource::getUrl('index')),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Procurement::query()->with('items')->where('status', 'requested')->orderBy('requested_at', 'desc'))
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Pengadaan')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('requested_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Total Item')
                    ->getStateUsing(function ($record) {
                        $totalQty = $record->items->sum('qty');
                        $totalTypes = $record->items->count();
                        return $totalQty . ' unit (' . $totalTypes . ' jenis)';
                    })
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Total Biaya')
                    ->getStateUsing(function ($record) {
                        $total = $record->items->sum(function ($item) {
                            return $item->qty * $item->unit_cost;
                        });
                        return 'Rp ' . number_format($total, 0, ',', '.');
                    })
                    ->weight('bold')
                    ->color('danger'),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(40)
                    ->wrap()
                    ->default('-')
                    ->toggleable(),
            ])
            ->actions([
                Action::make('view_details')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn ($record) => 'Detail Pengadaan: ' . $record->code)
                    ->modalDescription('Informasi lengkap tentang item yang dipesan')
                    ->modalContent(fn ($record) => view('filament.resources.finance.procurement-details', ['record' => $record]))
                    ->modalWidth('5xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->slideOver(),
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Pengadaan')
                    ->modalDescription(function ($record) {
                        $total = $record->items->sum(function ($item) {
                            return $item->qty * $item->unit_cost;
                        });
                        return 'Apakah Anda yakin ingin menyetujui pengadaan ' . $record->code . ' dengan total biaya Rp ' . number_format($total, 0, ',', '.') . '?';
                    })
                    ->action(function (Procurement $record) {
                        // Calculate total amount
                        $totalAmount = $record->items->sum(function ($item) {
                            return $item->qty * $item->unit_cost;
                        });
                        
                        // Update procurement status and total_cost
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                            'total_cost' => $totalAmount,
                        ]);

                        // Create expense record
                        Expense::create([
                            'procurement_id' => $record->id,
                            'date' => now(),
                            'category' => 'Pengadaan',
                            'description' => 'Pengadaan barang - ' . $record->code . ' (' . $record->items->count() . ' jenis item, total ' . $record->items->sum('qty') . ' unit)',
                            'amount' => $totalAmount,
                        ]);

                        Notification::make()
                            ->title('Pengadaan Disetujui')
                            ->body('Pengadaan ' . $record->code . ' sebesar Rp ' . number_format($totalAmount, 0, ',', '.') . ' telah disetujui dan dicatat sebagai pengeluaran.')
                            ->success()
                            ->send();
                    })
                    ->after(fn () => $this->resetTable()),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pengadaan')
                    ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin menolak pengadaan ' . $record->code . '? Status akan diubah menjadi "Dibatalkan".')
                    ->action(function (Procurement $record) {
                        $record->update([
                            'status' => 'canceled',
                        ]);

                        Notification::make()
                            ->title('Pengadaan Ditolak')
                            ->body('Pengadaan ' . $record->code . ' telah ditolak dan dibatalkan.')
                            ->warning()
                            ->send();
                    })
                    ->after(fn () => $this->resetTable()),
            ])
            ->emptyStateHeading('Tidak Ada Pengadaan Menunggu Persetujuan')
            ->emptyStateDescription('Semua pengadaan yang diajukan sudah diproses.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}

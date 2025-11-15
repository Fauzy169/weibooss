<?php

namespace App\Filament\Pages\Reports;

use Illuminate\Support\Facades\Auth;
use App\Filament\Navigation\NavigationGroup;
use App\Models\Expense;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class ExpenseReport extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationLabel = 'Laporan Pengeluaran';
    
    protected static ?string $title = 'Laporan Pengeluaran';
    
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Laporan;
    
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'owner']);
    }

    public function getView(): string
    {
        return 'filament.pages.reports.expense-report';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Expense::query()
                    ->orderBy('date', 'desc')
            )
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('source_type')
                    ->label('Sumber')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->procurement_id ? 'Pengadaan' : 'Manual')
                    ->color(fn (string $state): string => match ($state) {
                        'Pengadaan' => 'info',
                        'Manual' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pengadaan' => 'info',
                        'Operasional' => 'warning',
                        'Gaji & Upah' => 'success',
                        'Utilitas' => 'purple',
                        'Marketing' => 'pink',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable()
                    ->color('danger')
                    ->weight('bold')
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->money('IDR')
                            ->label('Total Pengeluaran'),
                    ]),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('date_range')
                    ->formSchema([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('date', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('date', '<=', $data['until']));
                    }),
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Pengadaan' => 'Pengadaan',
                        'Operasional' => 'Operasional',
                        'Gaji & Upah' => 'Gaji & Upah',
                        'Utilitas' => 'Utilitas',
                        'Perawatan' => 'Perawatan',
                        'Transportasi' => 'Transportasi',
                        'Marketing' => 'Marketing',
                        'Administrasi' => 'Administrasi',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->multiple(),
                \Filament\Tables\Filters\SelectFilter::make('source')
                    ->label('Sumber')
                    ->options([
                        'procurement' => 'Dari Pengadaan',
                        'manual' => 'Manual',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'procurement') {
                            return $query->whereNotNull('procurement_id');
                        } elseif ($data['value'] === 'manual') {
                            return $query->whereNull('procurement_id');
                        }
                        return $query;
                    }),
            ])
            ->defaultSort('date', 'desc');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ExpenseStatsWidget::class,
        ];
    }
}

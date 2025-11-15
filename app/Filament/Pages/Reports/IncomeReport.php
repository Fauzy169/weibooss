<?php

namespace App\Filament\Pages\Reports;

use App\Filament\Navigation\NavigationGroup;
use App\Models\Order;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\DB;

class IncomeReport extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationLabel = 'Laporan Pemasukan';
    
    protected static ?string $title = 'Laporan Pemasukan';
    
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Laporan;
    
    protected static ?int $navigationSort = 1;

    public function getView(): string
    {
        return 'filament.pages.reports.income-report';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', 'paid')
                    ->whereNotNull('placed_at')
                    ->orderBy('placed_at', 'desc')
            )
            ->columns([
                TextColumn::make('id')
                    ->label('Order #')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('placed_at')
                    ->label('Tanggal Pembayaran')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => 'Terbayar')
                    ->color('success')
                    ->label('Status'),
                TextColumn::make('total')
                    ->label('Nominal Pemasukan')
                    ->money('IDR')
                    ->sortable()
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->money('IDR')
                            ->label('Total Pemasukan Terbayar'),
                    ]),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('date_range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('placed_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('placed_at', '<=', $data['until']));
                    }),
            ])
            ->heading('Laporan Pemasukan Terbayar')
            ->description('Menampilkan hanya order yang sudah terbayar (status: paid)')
            ->defaultSort('placed_at', 'desc');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\IncomeStatsWidget::class,
        ];
    }
}

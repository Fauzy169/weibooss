<?php

namespace App\Filament\Pages\Reports;

use App\Filament\Navigation\NavigationGroup;
use App\Models\InventoryItem;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class StockReport extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationLabel = 'Laporan Stok Bahan';
    
    protected static ?string $title = 'Laporan Stok Bahan & Produk';
    
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Laporan;
    
    protected static ?int $navigationSort = 3;

    public function getView(): string
    {
        return 'filament.pages.reports.stock-report';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InventoryItem::query()
                    ->with(['itemable'])
                    ->orderBy('name', 'asc')
            )
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->item_type ? 'Tipe: ' . ucfirst($record->item_type) : 'Raw Material'),
                TextColumn::make('current_stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->current_stock <= $record->min_stock ? 'danger' : ($record->current_stock <= ($record->min_stock * 2) ? 'warning' : 'success'))
                    ->weight(fn ($record) => $record->current_stock <= $record->min_stock ? 'bold' : 'normal')
                    ->icon(fn ($record) => $record->current_stock <= $record->min_stock ? 'heroicon-o-exclamation-triangle' : null)
                    ->description(fn ($record) => $record->current_stock <= $record->min_stock ? 'Stok Menipis!' : null),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('min_stock')
                    ->label('Min. Stok')
                    ->numeric()
                    ->toggleable(),
                TextColumn::make('cost')
                    ->label('Harga Satuan')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('stock_value')
                    ->label('Nilai Stok')
                    ->state(fn ($record) => $record->current_stock * $record->cost)
                    ->money('IDR'),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('low_stock')
                    ->label('Stok Menipis')
                    ->query(fn ($query) => $query->whereRaw('current_stock <= min_stock'))
                    ->toggle(),
                \Filament\Tables\Filters\SelectFilter::make('item_type')
                    ->label('Tipe Item')
                    ->options([
                        'product' => 'Produk',
                        'service' => 'Service',
                        '' => 'Raw Material',
                    ]),
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->defaultSort('current_stock', 'asc');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StockStatsWidget::class,
        ];
    }
}

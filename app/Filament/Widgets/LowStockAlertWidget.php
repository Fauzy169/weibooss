<?php

namespace App\Filament\Widgets;

use App\Models\InventoryItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class LowStockAlertWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'owner', 'gudang']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InventoryItem::query()
                    ->whereRaw('current_stock <= min_stock')
                    ->orderBy('current_stock', 'asc')
                    ->limit(10)
            )
            ->heading('⚠️ Item dengan Stok Menipis')
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Item')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('current_stock')
                    ->label('Stok')
                    ->badge()
                    ->color('danger')
                    ->suffix(' unit'),
                Tables\Columns\TextColumn::make('min_stock')
                    ->label('Min. Stok')
                    ->badge()
                    ->color('warning')
                    ->suffix(' unit'),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->paginated(false);
    }
}

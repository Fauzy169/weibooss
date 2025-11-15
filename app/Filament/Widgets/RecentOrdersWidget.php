<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'owner', 'kasir', 'keuangan']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->whereNotNull('placed_at')
                    ->latest('placed_at')
                    ->limit(10)
            )
            ->heading('📋 10 Order Terbaru')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order #')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Terbayar',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'completed' => 'info',
                        'processing' => 'warning',
                        'canceled' => 'danger',
                        'pending' => 'gray',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success'),
                Tables\Columns\TextColumn::make('placed_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}

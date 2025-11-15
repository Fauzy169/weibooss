<?php

namespace App\Filament\Resources\Finance;

use Illuminate\Support\Facades\Auth;
use App\Filament\Navigation\NavigationGroup;
use App\Filament\Resources\Finance\IncomeResource\Pages;
use App\Models\Order;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IncomeResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Pemasukan';
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Keuangan;
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'keuangan']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Terbayar',
                        'canceled' => 'Dibatalkan',
                        'placed', 'checkout' => 'Placed/Checkout',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'canceled' => 'danger',
                        'placed', 'checkout' => 'gray',
                        default => 'warning',
                    })
                    ->label('Status'),
                TextColumn::make('placed_at')->dateTime('Y-m-d H:i')->label('Tanggal')->sortable(),
                TextColumn::make('total')->money('IDR')->label('Total')->sortable(),
                TextColumn::make('updated_at')->since()->label('Diubah'),
            ])
            ->recordActions([
                ViewAction::make()->label('Detail'),
            ])
            ->defaultSort('placed_at', 'desc');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomes::route('/'),
            'view' => Pages\ViewIncome::route('/{record}'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\IncomeResource\Pages;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IncomeResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Pemasukan';
    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('placed_at')->dateTime('Y-m-d H:i')->label('Tanggal')->sortable(),
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
                TextColumn::make('subtotal')->money('IDR')->label('Subtotal')->sortable(),
                TextColumn::make('total')->money('IDR')->label('Total')->sortable(),
                TextColumn::make('user.name')->label('User')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->since()->label('Diubah'),
            ])
            ->recordActions([
                ViewAction::make()->label('Detail'),
            ])
            ->defaultSort('placed_at', 'desc');
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([
            Section::make('Ringkasan Order')->schema([
                Placeholder::make('order_id')->label('Order #')
                    ->content(fn (Order $record): string => (string) $record->id),
                Placeholder::make('user_name')->label('User')
                    ->content(fn (Order $record): string => optional($record->user)->name ?? 'Guest'),
                Placeholder::make('placed_at')->label('Tanggal')
                    ->content(fn (Order $record): string => optional($record->placed_at)?->format('Y-m-d H:i') ?? '-'),
                Placeholder::make('status')->label('Status')
                    ->content(fn (Order $record): string => ucfirst($record->status)),
                Placeholder::make('subtotal')->label('Subtotal')
                    ->content(fn (Order $record): string => 'Rp ' . number_format((float) $record->subtotal, 0, ',', '.')),
                Placeholder::make('total')->label('Total')
                    ->content(fn (Order $record): string => 'Rp ' . number_format((float) $record->total, 0, ',', '.')),
                Placeholder::make('notes')->label('Catatan')
                    ->content(fn (Order $record): string => $record->notes ?: '-')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Item')->schema([
                Repeater::make('items')
                    ->relationship('items')
                    ->disabled()
                    ->columns(4)
                    ->schema([
                        Placeholder::make('name')->label('Produk')->content(fn ($record) => $record->name),
                        Placeholder::make('qty')->label('Qty')->content(fn ($record) => (string) $record->qty),
                        Placeholder::make('price')->label('Harga')->content(fn ($record) => 'Rp ' . number_format((float) $record->price, 0, ',', '.')),
                        Placeholder::make('subtotal')->label('Subtotal')->content(fn ($record) => 'Rp ' . number_format((float) $record->subtotal, 0, ',', '.')),
                    ])
                    ->grid(1)
                    ->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
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

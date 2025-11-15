<?php

namespace App\Filament\Resources\Warehouse;

use App\Filament\Navigation\NavigationGroup;
use App\Filament\Resources\Warehouse\InventoryItemResource\Pages;
use App\Models\InventoryItem;
use App\Models\StockMovement;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Service;

class InventoryItemResource extends Resource
{
    protected static ?string $model = InventoryItem::class;

    protected static ?string $navigationLabel = 'Stok & Bahan';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Gudang;
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Dasar')
                ->description('Informasi dasar mengenai barang/bahan')
                ->schema([
                    TextInput::make('sku')
                        ->label('SKU')
                        ->maxLength(50)
                        ->placeholder('Contoh: BRG-001')
                        ->columnSpan(1),
                    TextInput::make('name')
                        ->label('Nama Barang')
                        ->required()
                        ->maxLength(255)
                        ->disabled(fn ($record) => filled(optional($record)->item_type))
                        ->placeholder('Nama lengkap barang')
                        ->columnSpan(2),
                    TextInput::make('unit')
                        ->label('Satuan')
                        ->default('pcs')
                        ->maxLength(20)
                        ->placeholder('pcs, kg, meter, dll')
                        ->columnSpan(1),
                ])->columns(4),
            
            Section::make('Informasi Stok & Biaya')
                ->description('Kelola stok dan harga barang')
                ->schema([
                    TextInput::make('current_stock')
                        ->label('Stok Saat Ini')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->suffix('unit')
                        ->helperText('Jumlah stok yang tersedia saat ini'),
                    TextInput::make('min_stock')
                        ->label('Stok Minimum')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->suffix('unit')
                        ->helperText('Stok minimum sebelum perlu restock'),
                    TextInput::make('cost')
                        ->label('Biaya per Unit')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Harga pokok per unit'),
                    Toggle::make('is_active')
                        ->label('Status Aktif')
                        ->default(true)
                        ->inline(false)
                        ->helperText('Aktifkan item ini'),
                ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),
                TextColumn::make('item_type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        Product::class => 'Produk',
                        Service::class => 'Service',
                        default => '-',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        Product::class => 'success',
                        Service::class => 'info',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->alignCenter(),
                TextColumn::make('current_stock')
                    ->label('Stok')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state, $record) => $state <= $record->min_stock ? 'danger' : ($state <= $record->min_stock * 2 ? 'warning' : 'success')),
                TextColumn::make('min_stock')
                    ->label('Min')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('cost')
                    ->label('Biaya/Unit')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(),
            ])
            ->recordActions([
                ViewAction::make()->label('Detail'),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryItems::route('/'),
            'create' => Pages\CreateInventoryItem::route('/create'),
            'edit' => Pages\EditInventoryItem::route('/{record}/edit'),
            'view' => Pages\ViewInventoryItem::route('/{record}'),
        ];
    }
}

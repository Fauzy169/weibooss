<?php

namespace App\Filament\Resources\Warehouse;

use App\Filament\Navigation\NavigationGroup;
use App\Filament\Resources\Warehouse\ProcurementResource\Pages;
use App\Models\InventoryItem;
use App\Models\Procurement;
use App\Models\ProcurementItem;
use App\Models\StockMovement;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProcurementResource extends Resource
{
    protected static ?string $model = Procurement::class;

    protected static ?string $navigationLabel = 'Pengadaan';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Gudang;
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Pengadaan')
                ->description('Detail pengadaan dan kode transaksi')
                ->schema([
                    TextInput::make('code')
                        ->label('Kode Pengadaan')
                        ->default(fn () => 'PO-' . Str::upper(Str::random(8)))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(50)
                        ->placeholder('PO-XXXXXXXX')
                        ->helperText('Kode akan digenerate otomatis'),
                    Select::make('status')
                        ->label('Status')
                        ->default('draft')
                        ->options([
                            'draft' => 'Draft',
                            'requested' => 'Diminta',
                            'approved' => 'Disetujui',
                            'received' => 'Diterima',
                            'canceled' => 'Dibatalkan',
                        ])
                        ->disabled(fn ($record) => $record === null)
                        ->helperText('Status pengadaan'),
                    Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(3)
                        ->placeholder('Tambahkan catatan untuk pengadaan ini (opsional)')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Daftar Item Pengadaan')
                ->description('Pilih item yang sudah ada atau buat item baru')
                ->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->defaultItems(1)
                        ->live()
                        ->schema([
                            Select::make('inventory_item_id')
                                ->label('Pilih Item yang Ada')
                                ->relationship('inventoryItem', 'name')
                                ->searchable(['name', 'sku'])
                                ->preload()
                                ->live(onBlur: true)
                                ->createOptionForm([
                                    TextInput::make('sku')
                                        ->label('SKU')
                                        ->maxLength(50)
                                        ->placeholder('Contoh: BRG-001'),
                                    TextInput::make('name')
                                        ->label('Nama Item')
                                        ->required()
                                        ->maxLength(255)
                                        ->placeholder('Nama lengkap item'),
                                    TextInput::make('unit')
                                        ->label('Satuan')
                                        ->default('pcs')
                                        ->maxLength(20)
                                        ->placeholder('pcs, kg, meter, dll'),
                                    TextInput::make('cost')
                                        ->label('Biaya per Unit')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->minValue(0),
                                ])
                                ->createOptionUsing(function (array $data): int {
                                    $item = InventoryItem::create([
                                        'sku' => $data['sku'] ?? null,
                                        'name' => $data['name'],
                                        'unit' => $data['unit'] ?? 'pcs',
                                        'cost' => $data['cost'] ?? 0,
                                        'current_stock' => 0,
                                        'min_stock' => 0,
                                        'is_active' => true,
                                    ]);
                                    return $item->id;
                                })
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    if ($state && $item = InventoryItem::find($state)) {
                                        $set('name', $item->name);
                                        $set('unit_cost', $item->cost);
                                        $qty = max(1, (int) ($get('qty') ?? 1));
                                        $set('subtotal', $item->cost * $qty);
                                    }
                                })
                                ->helperText('Pilih dari daftar atau klik "+ Buat baru" untuk menambah item baru')
                                ->columnSpan(2),
                            TextInput::make('name')
                                ->label('Nama Item')
                                ->disabled()
                                ->dehydrated(true)
                                ->columnSpan(2),
                            TextInput::make('qty')
                                ->label('Jumlah')
                                ->numeric()
                                ->minValue(1)
                                ->default(1)
                                ->required()
                                ->live(onBlur: true)
                                ->suffix('unit')
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $unitCost = (float) ($get('unit_cost') ?? 0);
                                    $qty = max(1, (int) ($state ?? 1));
                                    $subtotal = $unitCost * $qty;
                                    $set('subtotal', $subtotal);
                                })
                                ->columnSpan(1),
                            TextInput::make('unit_cost')
                                ->label('Harga/Unit')
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->prefix('Rp')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $qty = max(1, (int) ($get('qty') ?? 1));
                                    $unitCost = (float) ($state ?? 0);
                                    $subtotal = $unitCost * $qty;
                                    $set('subtotal', $subtotal);
                                })
                                ->columnSpan(1),
                            TextInput::make('subtotal')
                                ->label('Subtotal')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false)
                                ->prefix('Rp')
                                ->default(0)
                                ->columnSpan(1),
                        ])
                        ->columns(7)
                        ->addActionLabel('+ Tambah Item Lain')
                        ->reorderableWithButtons()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Item Baru')
                        ->columnSpanFull()
                        ->minItems(1),
                ])->columnSpanFull(),
            
            Section::make('Total')
                ->schema([
                    Placeholder::make('total_calculation')
                        ->label('Total Pengadaan')
                        ->content(function ($get, $record) {
                            $items = $get('items') ?? [];
                            $total = 0;
                            
                            if (is_array($items)) {
                                foreach ($items as $item) {
                                    if (isset($item['qty']) && isset($item['unit_cost'])) {
                                        $qty = (int) $item['qty'];
                                        $cost = (float) $item['unit_cost'];
                                        $total += $qty * $cost;
                                    }
                                }
                            }
                            
                            if ($total > 0) {
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }
                            
                            return $record && $record->total_cost 
                                ? 'Rp ' . number_format($record->total_cost, 0, ',', '.') 
                                : 'Rp 0';
                        })
                        ->columnSpanFull(),
                ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode Pengadaan')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->copyMessage('Kode disalin')
                    ->copyMessageDuration(1500),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'draft' => 'Draft',
                        'requested' => 'Diminta',
                        'approved' => 'Disetujui',
                        'received' => 'Diterima',
                        'canceled' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray',
                        'requested' => 'warning',
                        'approved' => 'info',
                        'received' => 'success',
                        'canceled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('total_items')
                    ->label('Jumlah Item')
                    ->getStateUsing(function ($record) {
                        return $record->items->sum('qty');
                    })
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->suffix(' unit'),
                TextColumn::make('total_cost')
                    ->label('Total Biaya')
                    ->getStateUsing(function ($record) {
                        return $record->total_cost ?? 0;
                    })
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('requested_at')
                    ->label('Tgl Pengadaan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->since()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('requested_at', 'desc')
            ->recordActions([
                ViewAction::make()->label('Detail'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcurements::route('/'),
            'create' => Pages\CreateProcurement::route('/create'),
            'edit' => Pages\EditProcurement::route('/{record}/edit'),
            'view' => Pages\ViewProcurement::route('/{record}'),
        ];
    }
}

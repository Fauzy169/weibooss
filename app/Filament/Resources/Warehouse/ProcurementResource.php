<?php

namespace App\Filament\Resources\Warehouse;

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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProcurementResource extends Resource
{
    protected static ?string $model = Procurement::class;

    protected static ?string $navigationLabel = 'Pengadaan';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static string|\UnitEnum|null $navigationGroup = 'Gudang';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Ringkasan')
                ->schema([
                    TextInput::make('code')
                        ->label('Kode')
                        ->default(fn () => 'PO-' . Str::upper(Str::random(6)))
                        ->required()
                        ->unique(ignoreRecord: true),
                    TextInput::make('status')->label('Status')->default('draft')->disabled(),
                    Textarea::make('notes')->label('Catatan')->columnSpanFull(),
                ])->columns(2),

            Section::make('Item')
                ->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->defaultItems(0)
                        ->columns(5)
                        ->schema([
                            Select::make('inventory_item_id')
                                ->label('Item')
                                ->relationship('inventoryItem', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($item = InventoryItem::find($state)) {
                                        $set('name', $item->name);
                                        $set('unit_cost', $item->cost);
                                    }
                                }),
                            TextInput::make('name')->label('Nama')->disabled(),
                            TextInput::make('qty')->label('Qty')->numeric()->minValue(1)->default(1)->reactive()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('subtotal', (float) ($get('unit_cost') ?? 0) * max(1, (int) $state));
                                }),
                            TextInput::make('unit_cost')->label('Biaya/Unit')->numeric()->reactive()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('subtotal', (float) $state * max(1, (int) ($get('qty') ?? 1)));
                                }),
                            TextInput::make('subtotal')->label('Subtotal')->numeric()->disabled(),
                        ])
                        ->addActionLabel('Tambah Item')
                        ->orderable()
                        ->columnSpanFull(),
                ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Kode')->searchable(),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state) => match ($state) {
                    'draft' => 'gray',
                    'requested' => 'warning',
                    'approved' => 'info',
                    'received' => 'success',
                    'canceled' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('total_cost')->label('Total')->money('IDR')->sortable(),
                TextColumn::make('requested_at')->label('Diminta')->dateTime('Y-m-d H:i')->sortable(),
                TextColumn::make('updated_at')->label('Diubah')->since(),
            ])
            ->recordActions([
                ViewAction::make()->label('Detail'),
                EditAction::make()->label('Ubah'),
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

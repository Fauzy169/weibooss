<?php

namespace App\Filament\Resources\Finance;

use Illuminate\Support\Facades\Auth;
use App\Filament\Navigation\NavigationGroup;
use App\Filament\Resources\Finance\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Form as SchemaForm;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Pengeluaran';
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::Keuangan;
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'keuangan']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            SchemaForm::make()->schema([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->native(false)
                    ->default(now())
                    ->displayFormat('d M Y')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ]),
                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Operasional' => 'Operasional',
                        'Gaji & Upah' => 'Gaji & Upah',
                        'Utilitas' => 'Utilitas (Listrik, Air, Internet)',
                        'Perawatan' => 'Perawatan & Perbaikan',
                        'Transportasi' => 'Transportasi',
                        'Marketing' => 'Marketing & Promosi',
                        'Administrasi' => 'Administrasi',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->searchable()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ]),
                TextInput::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->step(1000)
                    ->columnSpan(2),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->required()
                    ->maxLength(500)
                    ->columnSpan(2)
                    ->placeholder('Jelaskan detail pengeluaran ini...'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Pengadaan' => 'heroicon-o-shopping-cart',
                        'Manual' => 'heroicon-o-pencil-square',
                        default => 'heroicon-o-document',
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
                TextColumn::make('procurement.code')
                    ->label('Kode Pengadaan')
                    ->url(fn ($record) => $record->procurement_id 
                        ? \App\Filament\Resources\Warehouse\ProcurementResource::getUrl('view', ['record' => $record->procurement_id])
                        : null)
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->placeholder('Manual')
                    ->toggleable(),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold')
                    ->color('danger'),
            ])
            ->filters([
                SelectFilter::make('source')
                    ->label('Sumber Pengeluaran')
                    ->options([
                        'procurement' => 'Dari Pengadaan',
                        'manual' => 'Manual (Non-Pengadaan)',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'procurement',
                            fn (Builder $query) => $query->whereNotNull('procurement_id'),
                            fn (Builder $query) => $data['value'] === 'manual' 
                                ? $query->whereNull('procurement_id')
                                : $query
                        );
                    }),
                SelectFilter::make('category')
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
                Filter::make('date')
                    ->formSchema([
                        DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->native(false),
                        DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('date', 'desc')
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
            'procurements' => Pages\ManageProcurements::route('/procurements'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = \App\Models\Procurement::where('status', 'requested')->count();
        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $pendingCount = \App\Models\Procurement::where('status', 'requested')->count();
        return $pendingCount > 0 ? $pendingCount . ' pengajuan pengadaan menunggu persetujuan' : null;
    }
}

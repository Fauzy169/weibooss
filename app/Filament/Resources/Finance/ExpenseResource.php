<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Form as SchemaForm;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-trending-down';
    protected static ?string $navigationLabel = 'Pengeluaran';
    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            SchemaForm::make()->schema([
                DatePicker::make('date')->required()->native(false)->displayFormat('Y-m-d'),
                TextInput::make('category')->maxLength(100),
                TextInput::make('amount')->numeric()->required()->prefix('Rp'),
                Textarea::make('description')->rows(3)->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->date('Y-m-d')->sortable(),
                TextColumn::make('category')->badge()->toggleable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('amount')->money('IDR')->sortable(),
                TextColumn::make('updated_at')->since()->label('Diubah')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\BajuPengantin;

use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Filament\Resources\BajuPengantin\Pages\CreateBajuPengantin;
use App\Filament\Resources\BajuPengantin\Pages\EditBajuPengantin;
use App\Filament\Resources\BajuPengantin\Pages\ListBajuPengantin;
use App\Models\Category;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BajuPengantinResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Baju Pengantin';

    protected static ?string $modelLabel = 'Baju Pengantin';

    public static function form(Schema $schema): Schema
    {
        // Reuse generic product form; category will be forced in page classes
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $id = static::categoryId();
        return $id ? $query->whereHas('categories', fn($q) => $q->where('categories.id', $id)) : $query;
    }

    protected static function categoryId(): ?int
    {
        $cat = Category::where('slug', 'baju-pengantin')->orWhere('name', 'Baju Pengantin')->first();
        return $cat?->id;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBajuPengantin::route('/'),
            'create' => Pages\CreateBajuPengantin::route('/create'),
            'edit' => Pages\EditBajuPengantin::route('/{record}/edit'),
        ];
    }
}

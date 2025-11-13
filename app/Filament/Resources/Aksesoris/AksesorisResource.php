<?php

namespace App\Filament\Resources\Aksesoris;

use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Filament\Resources\Aksesoris\Pages\CreateAksesoris;
use App\Filament\Resources\Aksesoris\Pages\EditAksesoris;
use App\Filament\Resources\Aksesoris\Pages\ListAksesoris;
use App\Models\Category;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AksesorisResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Aksesoris';

    protected static ?string $modelLabel = 'Aksesoris';

    public static function form(Schema $schema): Schema
    {
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
        $cat = Category::where('slug', 'aksesoris')->orWhere('name', 'Aksesoris')->first();
        return $cat?->id;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAksesoris::route('/'),
            'create' => Pages\CreateAksesoris::route('/create'),
            'edit' => Pages\EditAksesoris::route('/{record}/edit'),
        ];
    }
}

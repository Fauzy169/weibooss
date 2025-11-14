<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;

class ProductForm
{
    /**
     * Configure the shared Product form.
     *
     * @param Schema $schema  Incoming schema
     * @param int|null $primaryCategoryId  When provided, the categories selector will exclude this ID and be labeled as related categories
     * @param string|null $primaryCategoryName Optional label to display the primary category as read-only info
     */
    public static function configure(Schema $schema, ?int $primaryCategoryId = null, ?string $primaryCategoryName = null): Schema
    {
        $categoriesLabel = $primaryCategoryId ? 'Kategori Terkait' : 'Categories';

        return $schema
            ->components([
                // Optional display of primary category info
                ...($primaryCategoryName ? [
                    Section::make('Kategori')->schema([
                        Placeholder::make('primary_category_info')
                            ->label('Kategori Utama')
                            ->content($primaryCategoryName . ' (otomatis)')
                            ->columnSpanFull(),
                    ])
                ] : []),

                Select::make('categories')
                    ->label($categoriesLabel)
                    ->relationship(
                        name: 'categories',
                        titleAttribute: 'name',
                        modifyQueryUsing: $primaryCategoryId
                            ? fn ($query) => $query->where('categories.id', '!=', $primaryCategoryId)
                            : null
                    )
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText($primaryCategoryId ? 'Pilih kategori tambahan yang terkait. Kategori utama diset otomatis.' : null),
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),
                FileUpload::make('image')
                    ->image()
                    ->label('Primary Image')
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public'),
                FileUpload::make('gallery')
                    ->image()
                    ->label('Gallery Images (max 4)')
                    ->multiple()
                    ->maxFiles(4)
                    ->reorderable()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->helperText('Upload up to 4 additional images.'),
            ]);
    }
}

<?php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Auth;
use App\Filament\Navigation\NavigationGroup;
use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Form as SchemaForm;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
// Note: Some Filament builds may not include Tables Actions classes; we'll avoid explicit actions for compatibility.

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    
    protected static \UnitEnum|string|null $navigationGroup = NavigationGroup::SalesContent;
    
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'sales']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            SchemaForm::make()->schema([
                TextInput::make('subtitle')->label('Badge/Sub Title')->maxLength(150),
                TextInput::make('title')->required()->maxLength(255),
                Textarea::make('description')->rows(4),

                FileUpload::make('image')
                    ->image()
                    ->directory('banners')
                    ->disk('public')
                    ->imageEditor()
                    ->imageCropAspectRatio('16:9'),

                TextInput::make('button_text')->maxLength(100),
                TextInput::make('button_url')->url()->maxLength(255),

                TextInput::make('position')->default('home-hero')->maxLength(50),
                Toggle::make('active')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->disk('public')->square(),
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('subtitle')->limit(30),
                TextColumn::make('position')->badge(),
                IconColumn::make('active')->boolean(),
                TextColumn::make('updated_at')->dateTime()->since(),
            ])
            // Provide clickable rows to edit instead of explicit actions for wider compatibility
            ->recordUrl(fn ($record) => url('/admin/banners/' . $record->id . '/edit'))
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}

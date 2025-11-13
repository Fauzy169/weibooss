<?php

namespace App\Filament\Resources\Promotions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(debounce: 400),
                TextInput::make('subtitle'),
                Textarea::make('description')
                    ->columnSpanFull(),
                DateTimePicker::make('deadline_at')
                    ->seconds(false)
                    ->label('Berakhir Pada'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('promotions')
                    ->visibility('public')
                    ->imageEditor(),
                FileUpload::make('small_icon')
                    ->image()
                    ->disk('public')
                    ->directory('promotions/icons')
                    ->visibility('public')
                    ->imageEditor()
                    ->label('Ikon Kecil'),
                TextInput::make('button_text'),
                TextInput::make('button_url')
                    ->url(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}

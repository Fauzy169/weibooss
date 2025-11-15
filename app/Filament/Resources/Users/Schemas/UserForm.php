<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                Textarea::make('address')
                    ->columnSpanFull(),
                Select::make('role')
                    ->label('User Role')
                    ->options([
                        'super_admin' => '👑 Super Admin',
                        'administrator' => '🔐 Administrator',
                        'owner' => '👔 Owner',
                        'keuangan' => '💰 Keuangan',
                        'gudang' => '📦 Gudang',
                        'sales' => '🛍️ Sales',
                        'kasir' => '💳 Kasir',
                        'customer' => '👤 Customer',
                    ])
                    ->required()
                    ->default('customer')
                    ->native(false),
            ]);
    }
}

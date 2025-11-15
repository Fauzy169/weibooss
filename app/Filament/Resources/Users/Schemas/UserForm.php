<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpan(2),
                
                Select::make('role')
                    ->label('User Role')
                    ->required()
                    ->options([
                        'administrator' => 'Administrator',
                        'customer' => 'Customer',
                        'sales' => 'Sales',
                        'kasir' => 'Kasir',
                        'keuangan' => 'Keuangan',
                        'owner' => 'Owner',
                        'gudang' => 'Gudang',
                    ])
                    ->default('customer')
                    ->native(false)
                    ->searchable()
                    ->columnSpan(1),
                
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(20)
                    ->columnSpan(1),
                
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn (?string $state): ?string => $state ? Hash::make($state) : null)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255)
                    ->helperText(fn (string $operation): string => 
                        $operation === 'edit' 
                            ? 'Leave blank to keep current password' 
                            : 'Enter password for new user'
                    )
                    ->columnSpan(2),
                
                Textarea::make('address')
                    ->label('Address')
                    ->rows(3)
                    ->columnSpan(2),
            ]);
    }
}

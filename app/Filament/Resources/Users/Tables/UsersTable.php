<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied'),
                
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'administrator' => 'warning',
                        'owner' => 'info',
                        'sales' => 'success',
                        'kasir' => 'primary',
                        'keuangan' => 'gray',
                        'gudang' => 'secondary',
                        'customer' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'administrator' => 'Administrator',
                        'owner' => 'Owner',
                        'keuangan' => 'Keuangan',
                        'gudang' => 'Gudang',
                        'sales' => 'Sales',
                        'kasir' => 'Kasir',
                        'customer' => 'Customer',
                        default => ucfirst($state),
                    })
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'administrator' => 'Administrator',
                        'owner' => 'Owner',
                        'keuangan' => 'Keuangan',
                        'gudang' => 'Gudang',
                        'sales' => 'Sales',
                        'kasir' => 'Kasir',
                        'customer' => 'Customer',
                    ])
                    ->multiple(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

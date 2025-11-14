<?php

namespace App\Filament\Resources\Finance\IncomeResource\Pages;

use App\Filament\Resources\Finance\IncomeResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewIncome extends ViewRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('markPlaced')
                ->label('Set Placed/Checkout')
                ->color('gray')
                ->requiresConfirmation()
                ->visible(fn (Order $record): bool => $record->status !== 'placed' && $record->status !== 'checkout')
                ->action(function (Order $record): void {
                    $record->update(['status' => 'placed']);
                }),
            Action::make('markPaid')
                ->label('Tandai Terbayar')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Order $record): bool => $record->status !== 'paid')
                ->action(function (Order $record): void {
                    $record->update(['status' => 'paid']);
                }),
            Action::make('cancel')
                ->label('Batalkan')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Order $record): bool => $record->status !== 'canceled')
                ->action(function (Order $record): void {
                    $record->update(['status' => 'canceled']);
                }),
        ];
    }
}

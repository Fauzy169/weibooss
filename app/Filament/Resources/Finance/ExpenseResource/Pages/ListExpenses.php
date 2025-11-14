<?php

namespace App\Filament\Resources\Finance\ExpenseResource\Pages;

use App\Filament\Resources\Finance\ExpenseResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

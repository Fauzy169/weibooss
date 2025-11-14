<?php

namespace App\Filament\Resources\Finance\IncomeResource\Pages;

use App\Filament\Resources\Finance\IncomeResource;
use Filament\Resources\Pages\ListRecords;

class ListIncomes extends ListRecords
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

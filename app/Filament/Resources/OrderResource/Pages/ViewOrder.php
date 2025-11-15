<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\Page;

class ViewOrder extends Page
{
    protected static string $resource = OrderResource::class;

    protected string $view = 'filament.resources.order.view-order';

    public $record;

    public function mount($record): void
    {
        $this->record = OrderResource::getModel()::with(['user', 'items'])->findOrFail($record);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

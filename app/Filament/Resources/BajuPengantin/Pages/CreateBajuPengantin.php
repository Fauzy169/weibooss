<?php

namespace App\Filament\Resources\BajuPengantin\Pages;

use App\Filament\Resources\BajuPengantin\BajuPengantinResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;

class CreateBajuPengantin extends CreateRecord
{
    protected static string $resource = BajuPengantinResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $categoryId = Category::where('slug', 'baju-pengantin')->orWhere('name', 'Baju Pengantin')->value('id');
        if ($categoryId) {
            $data['category_id'] = $categoryId; // set primary
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $categoryId = Category::where('slug', 'baju-pengantin')->orWhere('name', 'Baju Pengantin')->value('id');
        if ($categoryId) {
            $this->record->categories()->syncWithoutDetaching([$categoryId]);
        }
    }
}

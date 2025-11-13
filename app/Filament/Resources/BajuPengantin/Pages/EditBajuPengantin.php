<?php

namespace App\Filament\Resources\BajuPengantin\Pages;

use App\Filament\Resources\BajuPengantin\BajuPengantinResource;
use App\Models\Category;
use Filament\Resources\Pages\EditRecord;

class EditBajuPengantin extends EditRecord
{
    protected static string $resource = BajuPengantinResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $categoryId = Category::where('slug', 'baju-pengantin')->orWhere('name', 'Baju Pengantin')->value('id');
        if ($categoryId) {
            $data['category_id'] = $categoryId; // keep primary
        }
        return $data;
    }

    protected function afterSave(): void
    {
        $categoryId = Category::where('slug', 'baju-pengantin')->orWhere('name', 'Baju Pengantin')->value('id');
        if ($categoryId) {
            $this->record->categories()->syncWithoutDetaching([$categoryId]);
        }
    }
}

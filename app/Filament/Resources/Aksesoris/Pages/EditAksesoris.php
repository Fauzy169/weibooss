<?php

namespace App\Filament\Resources\Aksesoris\Pages;

use App\Filament\Resources\Aksesoris\AksesorisResource;
use App\Models\Category;
use Filament\Resources\Pages\EditRecord;

class EditAksesoris extends EditRecord
{
    protected static string $resource = AksesorisResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $categoryId = Category::where('slug', 'aksesoris')->orWhere('name', 'Aksesoris')->value('id');
        if ($categoryId) {
            $data['category_id'] = $categoryId; // keep primary
        }
        return $data;
    }

    protected function afterSave(): void
    {
        $categoryId = Category::where('slug', 'aksesoris')->orWhere('name', 'Aksesoris')->value('id');
        if ($categoryId) {
            $this->record->categories()->syncWithoutDetaching([$categoryId]);
        }
    }
}

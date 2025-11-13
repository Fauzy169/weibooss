<?php

namespace App\Filament\Resources\Aksesoris\Pages;

use App\Filament\Resources\Aksesoris\AksesorisResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;

class CreateAksesoris extends CreateRecord
{
    protected static string $resource = AksesorisResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $categoryId = Category::where('slug', 'aksesoris')->orWhere('name', 'Aksesoris')->value('id');
        if ($categoryId) {
            $data['category_id'] = $categoryId; // set primary
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $categoryId = Category::where('slug', 'aksesoris')->orWhere('name', 'Aksesoris')->value('id');
        if ($categoryId) {
            $this->record->categories()->syncWithoutDetaching([$categoryId]);
        }
    }
}

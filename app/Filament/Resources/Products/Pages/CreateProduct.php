<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        // Ensure primary category_id is set from first selected category
        $firstCategoryId = optional($this->record->categories()->first())->id;
        if ($firstCategoryId && !$this->record->category_id) {
            $this->record->category_id = $firstCategoryId;
            $this->record->save();
        }
    }
}

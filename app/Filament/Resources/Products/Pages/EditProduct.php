<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    
        protected function afterSave(): void
        {
            // Keep primary category_id synced with first selected category
            $firstCategoryId = optional($this->record->categories()->first())->id;
            if ($firstCategoryId && $this->record->category_id !== $firstCategoryId) {
                $this->record->category_id = $firstCategoryId;
                $this->record->save();
            }
        }
}

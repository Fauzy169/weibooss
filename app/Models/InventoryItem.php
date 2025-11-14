<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 'name', 'unit', 'current_stock', 'min_stock', 'cost', 'is_active',
        'item_type', 'item_id',
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'min_stock' => 'integer',
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function itemable()
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function procurementItems(): HasMany
    {
        return $this->hasMany(ProcurementItem::class);
    }
}

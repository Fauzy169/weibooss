<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id', 'type', 'quantity', 'reason', 'procurement_id', 'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function procurement(): BelongsTo
    {
        return $this->belongsTo(Procurement::class);
    }
}

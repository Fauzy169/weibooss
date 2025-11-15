<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Procurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'status', 'total_cost', 'requested_at', 'approved_at', 'received_at', 'notes',
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ProcurementItem::class);
    }

    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function recalcTotal(): void
    {
        $total = $this->items()->sum('subtotal');
        $this->update(['total_cost' => $total]);
    }
}

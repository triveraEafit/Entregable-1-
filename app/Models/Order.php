<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date',
        'status',
        'total_amount',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
            'total_amount' => 'decimal:2',
        ];
    }

    // ------------------------------------------------------------------
    // Relaciones
    // ------------------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ------------------------------------------------------------------
    // Lógica de negocio del dominio
    // ------------------------------------------------------------------

    /**
     * Recalcula y persiste el total de la orden a partir de sus items.
     * Usa eager loading para evitar N+1 al recorrer los items.
     */
    public function calculateTotal(): float
    {
        $this->loadMissing('orderItems');

        $total = $this->orderItems->sum(
            fn (OrderItem $item) => (float) $item->subtotal
        );

        $this->total_amount = $total;
        $this->save();

        return $total;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'active',
        'brand_id',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    // ------------------------------------------------------------------
    // Relaciones (cada línea del diagrama de clases = 2 métodos)
    // ------------------------------------------------------------------

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ------------------------------------------------------------------
    // Accessor de solo lectura: precio formateado
    // ------------------------------------------------------------------

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => '$'.number_format((float) $this->price, 2),
        );
    }

    // ------------------------------------------------------------------
    // Lógica de negocio del dominio
    // ------------------------------------------------------------------

    /**
     * Verifica si hay unidades disponibles para la cantidad solicitada.
     */
    public function checkAvailability(int $quantity = 1): bool
    {
        return $this->active && $this->stock >= $quantity;
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }
}

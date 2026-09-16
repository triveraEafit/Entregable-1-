<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * PRODUCT ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['name'] - string - name of the product
 * $this->attributes['description'] - string|null - description of the product
 * $this->attributes['price'] - string - price of the product (decimal:2)
 * $this->attributes['stock'] - int - units available in stock
 * $this->attributes['image'] - string|null - path to the product image
 * $this->attributes['active'] - bool - whether the product is visible/purchasable
 * $this->attributes['brand_id'] - int - foreign key to brands table
 * $this->attributes['category_id'] - int - foreign key to categories table
 * $this->attributes['created_at'] - string - creation timestamp
 * $this->attributes['updated_at'] - string - update timestamp
 */
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

    // Setters
    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function setPrice(string $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function setActive(bool $active): void
    {
        $this->attributes['active'] = $active;
    }

    public function setBrandId(int $brandId): void
    {
        $this->attributes['brand_id'] = $brandId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }

    // Getters
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    public function getPrice(): string
    {
        return $this->attributes['price'];
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'];
    }

    public function getActive(): bool
    {
        return (bool) $this->attributes['active'];
    }

    public function getBrandId(): int
    {
        return $this->attributes['brand_id'];
    }

    public function getCategoryId(): int
    {
        return $this->attributes['category_id'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    // Non-primitive methods/relations
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

    /**
     * Only available when the query used withCount('reviews').
     */
    public function getReviewsCount(): int
    {
        return (int) ($this->attributes['reviews_count'] ?? 0);
    }

    public function getFormattedPrice(): string
    {
        return '$'.number_format((float) $this->getPrice(), 2);
    }

    public function checkAvailability(int $quantity = 1): bool
    {
        return $this->getActive() && $this->getStock() >= $quantity;
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * PRODUCT ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['name'] - string - name of the product
 * $this->attributes['description'] - string|null - description of the product
 * $this->attributes['price'] - float - unit price of the product
 * $this->attributes['stock'] - int - units available in the inventory
 * $this->attributes['image'] - string|null - path of the product image inside the public disk
 * $this->attributes['active'] - bool - whether the product is shown and can be bought in the store
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

    public function setPrice(float $price): void
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
        return (int) $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function getPrice(): float
    {
        return (float) $this->attributes['price'];
    }

    public function getStock(): int
    {
        return (int) ($this->attributes['stock'] ?? 0);
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function getActive(): bool
    {
        return (bool) ($this->attributes['active'] ?? true);
    }

    public function getBrandId(): int
    {
        return (int) $this->attributes['brand_id'];
    }

    public function getCategoryId(): int
    {
        return (int) $this->attributes['category_id'];
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

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    /**
     * Price formatted for the store, calculated from the price attribute.
     */
    public function getFormattedPrice(): string
    {
        return '$'.number_format($this->getPrice(), 2);
    }

    /**
     * Number of reviews calculated by withCount('reviews'). It is 0 when the query did not count them.
     */
    public function getReviewsCount(): int
    {
        return (int) ($this->attributes['reviews_count'] ?? 0);
    }

    /**
     * Units sold calculated by withSum() over the order items. It is 0 when the query did not add them.
     */
    public function getUnitsSold(): int
    {
        return (int) ($this->attributes['units_sold'] ?? 0);
    }

    /**
     * Checks that the product is active and has enough units for the requested quantity.
     */
    public function checkAvailability(int $quantity = 1): bool
    {
        return $this->getActive() && $this->getStock() >= $quantity;
    }

    /**
     * Subtracts the sold units with a single "stock = stock - quantity" update.
     */
    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock', $quantity);
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }
}

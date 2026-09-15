<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * CATEGORY ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['name'] - string - name of the category
 * $this->attributes['description'] - string|null - description of the category
 * $this->attributes['created_at'] - string - creation timestamp
 * $this->attributes['updated_at'] - string - update timestamp
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
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

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function getProductsCount(): int
    {
        return (int) ($this->attributes['products_count'] ?? 0);
    }

    // Non-primitive methods/relations
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

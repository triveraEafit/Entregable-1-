<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * BRAND ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['name'] - string - name of the brand
 * $this->attributes['country'] - string|null - country of origin of the brand
 * $this->attributes['website'] - string|null - official website of the brand
 * $this->attributes['created_at'] - string - creation timestamp
 * $this->attributes['updated_at'] - string - update timestamp
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'website',
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

    public function setCountry(?string $country): void
    {
        $this->attributes['country'] = $country;
    }

    public function setWebsite(?string $website): void
    {
        $this->attributes['website'] = $website;
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

    public function getCountry(): ?string
    {
        return $this->attributes['country'];
    }

    public function getWebsite(): ?string
    {
        return $this->attributes['website'];
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

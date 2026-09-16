<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * REVIEW ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['rating'] - int - rating from 1 to 5
 * $this->attributes['comment'] - string|null - review comment
 * $this->attributes['created_at_review'] - string - when the review was submitted
 * $this->attributes['user_id'] - int - foreign key to users table
 * $this->attributes['product_id'] - int - foreign key to products table
 * $this->attributes['created_at'] - string - creation timestamp
 * $this->attributes['updated_at'] - string - update timestamp
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'created_at_review',
        'user_id',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'created_at_review' => 'datetime',
        ];
    }

    // Setters
    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setRating(int $rating): void
    {
        $this->attributes['rating'] = $rating;
    }

    public function setComment(?string $comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    // Getters
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getRating(): int
    {
        return $this->attributes['rating'];
    }

    public function getComment(): ?string
    {
        return $this->attributes['comment'];
    }

    public function getCreatedAtReview(): string
    {
        return $this->attributes['created_at_review'];
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function getProductId(): int
    {
        return $this->attributes['product_id'];
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ORDER ITEM ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['quantity'] - int - number of units bought
 * $this->attributes['unit_price'] - float - price of one unit when the order was placed
 * $this->attributes['subtotal'] - float - quantity multiplied by the unit price
 * $this->attributes['order_id'] - int - foreign key to orders table
 * $this->attributes['product_id'] - int - foreign key to products table
 * $this->attributes['created_at'] - string - creation timestamp
 * $this->attributes['updated_at'] - string - update timestamp
 */
class OrderItem extends Model
{
    protected $fillable = [
        'quantity',
        'unit_price',
        'subtotal',
        'order_id',
        'product_id',
    ];

    // Setters
    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function setUnitPrice(float $unitPrice): void
    {
        $this->attributes['unit_price'] = $unitPrice;
    }

    public function setSubtotal(float $subtotal): void
    {
        $this->attributes['subtotal'] = $subtotal;
    }

    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    // Getters
    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getQuantity(): int
    {
        return (int) $this->attributes['quantity'];
    }

    public function getUnitPrice(): float
    {
        return (float) $this->attributes['unit_price'];
    }

    public function getSubtotal(): float
    {
        return (float) $this->attributes['subtotal'];
    }

    public function getOrderId(): int
    {
        return (int) $this->attributes['order_id'];
    }

    public function getProductId(): int
    {
        return (int) $this->attributes['product_id'];
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
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Calculates quantity x unit price and saves it as the subtotal of the item.
     */
    public function calculateSubtotal(): float
    {
        $subtotal = round($this->getUnitPrice() * $this->getQuantity(), 2);
        $this->setSubtotal($subtotal);
        $this->save();

        return $subtotal;
    }
}

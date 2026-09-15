<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Encapsulates the business logic that builds an order (SRP):
 * the controller only calls it and does not decide how an order is created.
 */
class OrderService
{
    /**
     * Creates the order and its items and discounts the stock in a single transaction.
     * Each product row is locked while it is checked, so two simultaneous purchases cannot
     * sell the same units. If any product fails the checks, nothing is saved.
     *
     * @param  array<int, array{product_id: int, quantity: int}>  $items
     *
     * @throws RuntimeException when a product is inactive or does not have enough stock
     */
    public function checkout(User $user, array $items): Order
    {
        return DB::transaction(function () use ($user, $items) {
            $order = Order::create([
                'order_date' => now(),
                'status' => 'pendiente',
                'total_amount' => 0,
                'user_id' => $user->id,
            ]);

            foreach ($items as $item) {
                $quantity = (int) $item['quantity'];
                $product = Product::query()->lockForUpdate()->findOrFail($item['product_id']);

                if (! $product->getActive()) {
                    throw new RuntimeException(__('products.unavailable', ['name' => $product->getName()]));
                }

                if (! $product->checkAvailability($quantity)) {
                    throw new RuntimeException(__('products.insufficient_stock', [
                        'name' => $product->getName(),
                        'stock' => $product->getStock(),
                    ]));
                }

                $orderItem = new OrderItem([
                    'quantity' => $quantity,
                    'unit_price' => $product->getPrice(),
                    'subtotal' => 0,
                    'product_id' => $product->getId(),
                ]);

                $order->orderItems()->save($orderItem);
                $orderItem->calculateSubtotal();

                $product->decreaseStock($quantity);
            }

            $order->calculateTotal();

            return $order->fresh(['orderItems.product']);
        });
    }
}

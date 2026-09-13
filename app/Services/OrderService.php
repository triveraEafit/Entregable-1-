<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Encapsula la lógica de negocio de creación de pedidos (SRP):
 * el controlador solo la invoca, no decide cómo se arma un pedido.
 */
class OrderService
{
    /**
     * @param  array<int, array{product_id:int, quantity:int}>  $items
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
                /** @var Product $product */
                $product = Product::query()->lockForUpdate()->findOrFail($item['product_id']);

                if (! $product->checkAvailability($item['quantity'])) {
                    throw new \RuntimeException("Sin stock suficiente para {$product->name}.");
                }

                $orderItem = new OrderItem([
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => 0,
                    'product_id' => $product->id,
                ]);

                $order->orderItems()->save($orderItem);
                $orderItem->calculateSubtotal();

                $product->decrement('stock', $item['quantity']);
            }

            $order->calculateTotal();

            return $order->fresh(['orderItems.product']);
        });
    }
}

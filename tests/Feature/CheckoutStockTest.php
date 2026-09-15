<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutStockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setLocale('es');
    }

    public function test_checkout_discounts_purchased_units_from_stock(): void
    {
        $product = Product::factory()->create(['price' => 250000, 'stock' => 10]);

        $response = $this->actingAs(User::factory()->create())->post(route('orders.checkout'), [
            'items' => [['product_id' => $product->getId(), 'quantity' => 3]],
        ]);

        $order = Order::sole();
        $response->assertRedirect(route('orders.show', ['id' => $order->getKey()]));
        $this->assertSame(7, $product->refresh()->getStock());
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->getKey(),
            'product_id' => $product->getId(),
            'quantity' => 3,
            'unit_price' => 250000,
            'subtotal' => 750000,
        ]);
        $this->assertDatabaseHas('orders', ['id' => $order->getKey(), 'total_amount' => 750000]);
    }

    public function test_checkout_can_sell_the_last_units_leaving_stock_at_zero(): void
    {
        $product = Product::factory()->create(['stock' => 2]);

        $response = $this->actingAs(User::factory()->create())->post(route('orders.checkout'), [
            'items' => [['product_id' => $product->getId(), 'quantity' => 2]],
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertSame(0, $product->refresh()->getStock());
    }

    public function test_checkout_rejects_quantity_above_stock_and_keeps_inventory(): void
    {
        $product = Product::factory()->create(['name' => 'Galaxy S24', 'stock' => 2]);
        $productPage = route('products.show', ['id' => $product->getId()]);

        $response = $this->actingAs(User::factory()->create())
            ->from($productPage)
            ->post(route('orders.checkout'), [
                'items' => [['product_id' => $product->getId(), 'quantity' => 3]],
            ]);

        $response->assertRedirect($productPage)
            ->assertSessionHasErrors(['stock' => 'No hay stock suficiente de Galaxy S24. Unidades disponibles: 2.']);
        $this->assertSame(2, $product->refresh()->getStock());
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    public function test_checkout_rejects_inactive_product(): void
    {
        $product = Product::factory()->inactive()->create(['name' => 'Nokia 3310', 'stock' => 5]);

        $response = $this->actingAs(User::factory()->create())->post(route('orders.checkout'), [
            'items' => [['product_id' => $product->getId(), 'quantity' => 1]],
        ]);

        $response->assertSessionHasErrors(['stock' => 'El producto Nokia 3310 no está disponible.']);
        $this->assertSame(5, $product->refresh()->getStock());
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_rolls_back_every_item_when_one_product_lacks_stock(): void
    {
        $available = Product::factory()->create(['stock' => 10]);
        $scarce = Product::factory()->create(['stock' => 1]);

        $response = $this->actingAs(User::factory()->create())->post(route('orders.checkout'), [
            'items' => [
                ['product_id' => $available->getId(), 'quantity' => 4],
                ['product_id' => $scarce->getId(), 'quantity' => 2],
            ],
        ]);

        $response->assertSessionHasErrors('stock');
        $this->assertSame(10, $available->refresh()->getStock());
        $this->assertSame(1, $scarce->refresh()->getStock());
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    public function test_checkout_counts_repeated_lines_of_a_product_against_its_stock(): void
    {
        $product = Product::factory()->create(['stock' => 5]);

        $response = $this->actingAs(User::factory()->create())->post(route('orders.checkout'), [
            'items' => [
                ['product_id' => $product->getId(), 'quantity' => 3],
                ['product_id' => $product->getId(), 'quantity' => 3],
            ],
        ]);

        $response->assertSessionHasErrors('stock');
        $this->assertSame(5, $product->refresh()->getStock());
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_product_page_shows_the_stock_error_after_a_failed_checkout(): void
    {
        $product = Product::factory()->create(['name' => 'Galaxy S24', 'stock' => 1]);

        $response = $this->actingAs(User::factory()->create())
            ->from(route('products.show', ['id' => $product->getId()]))
            ->followingRedirects()
            ->post(route('orders.checkout'), [
                'items' => [['product_id' => $product->getId(), 'quantity' => 5]],
            ]);

        $response->assertSee('No hay stock suficiente de Galaxy S24. Unidades disponibles: 1.');
    }
}

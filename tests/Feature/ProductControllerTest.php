<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setLocale('es');
    }

    public function test_catalog_lists_active_products_only(): void
    {
        Product::factory()->create(['name' => 'Galaxy S24']);
        Product::factory()->inactive()->create(['name' => 'Nokia 3310']);

        $response = $this->get(route('products.index'));

        $response->assertSee('Galaxy S24')->assertDontSee('Nokia 3310');
    }

    public function test_search_lists_only_products_matching_the_term(): void
    {
        Product::factory()->create(['name' => 'Laptop ThinkPad X1']);
        Product::factory()->create(['name' => 'Galaxy S24']);

        $response = $this->get(route('products.search', ['q' => 'ThinkPad']));

        $response->assertSee('Laptop ThinkPad X1')->assertDontSee('Galaxy S24');
    }

    public function test_search_keeps_the_term_in_pagination_links(): void
    {
        Product::factory()
            ->count(13)
            ->sequence(fn (Sequence $sequence) => ['name' => 'Laptop '.$sequence->index])
            ->create();

        $response = $this->get(route('products.search', ['q' => 'Laptop']));

        $response->assertSee('q=Laptop&amp;page=2', false);
    }

    public function test_show_renders_the_product_detail_with_its_stock(): void
    {
        $product = Product::factory()->create(['name' => 'Galaxy S24', 'price' => 3800000, 'stock' => 3]);

        $response = $this->get(route('products.show', ['id' => $product->getId()]));

        $response->assertSee('Galaxy S24')
            ->assertSee('$3,800,000.00')
            ->assertSee('3 unidades disponibles');
    }

    public function test_show_returns_404_for_inactive_product(): void
    {
        $product = Product::factory()->inactive()->create();

        $response = $this->get(route('products.show', ['id' => $product->getId()]));

        $response->assertNotFound();
    }

    public function test_top_selling_ranks_products_by_units_sold(): void
    {
        $laptop = Product::factory()->create(['name' => 'Laptop ThinkPad X1']);
        $phone = Product::factory()->create(['name' => 'Galaxy S24']);
        $mouse = Product::factory()->create(['name' => 'Mouse MX Master 3']);
        $this->sellProduct($laptop, 3);
        $this->sellProduct($phone, 5);
        $this->sellProduct($phone, 2);
        $this->sellProduct($mouse, 1);

        $response = $this->get(route('products.top-selling'));

        $response->assertSeeInOrder([
            'Galaxy S24', '7 unidades vendidas',
            'Laptop ThinkPad X1', '3 unidades vendidas',
            'Mouse MX Master 3', '1 unidad vendida',
        ]);
    }

    public function test_top_selling_ignores_units_from_cancelled_orders(): void
    {
        $laptop = Product::factory()->create(['name' => 'Laptop ThinkPad X1']);
        $phone = Product::factory()->create(['name' => 'Galaxy S24']);
        $headphones = Product::factory()->create(['name' => 'Audífonos WH-1000XM5']);
        $this->sellProduct($laptop, 2);
        $this->sellProduct($laptop, 10, 'cancelado');
        $this->sellProduct($phone, 5);
        $this->sellProduct($headphones, 4, 'cancelado');

        $response = $this->get(route('products.top-selling'));

        $response->assertSeeInOrder(['Galaxy S24', '5 unidades vendidas', 'Laptop ThinkPad X1', '2 unidades vendidas'])
            ->assertDontSee('Audífonos WH-1000XM5');
    }

    public function test_top_selling_excludes_inactive_products(): void
    {
        $phone = Product::factory()->create(['name' => 'Galaxy S24']);
        $oldPhone = Product::factory()->inactive()->create(['name' => 'Nokia 3310']);
        $this->sellProduct($phone, 1);
        $this->sellProduct($oldPhone, 20);

        $response = $this->get(route('products.top-selling'));

        $response->assertSee('Galaxy S24')->assertDontSee('Nokia 3310');
    }

    public function test_top_selling_shows_at_most_five_products(): void
    {
        foreach (range(1, 6) as $unitsSold) {
            $this->sellProduct(Product::factory()->create(['name' => "Producto {$unitsSold}"]), $unitsSold);
        }

        $response = $this->get(route('products.top-selling'));

        $response->assertSeeInOrder(['Producto 6', 'Producto 5', 'Producto 4', 'Producto 3', 'Producto 2'])
            ->assertDontSee('Producto 1');
    }

    public function test_top_selling_shows_a_message_when_nothing_was_sold(): void
    {
        Product::factory()->create(['name' => 'Galaxy S24']);

        $response = $this->get(route('products.top-selling'));

        $response->assertSee('Todavía no hay ventas registradas.')->assertDontSee('Galaxy S24');
    }

    private function sellProduct(Product $product, int $quantity, string $status = 'pagado'): void
    {
        $order = Order::create([
            'order_date' => now(),
            'status' => $status,
            'total_amount' => $product->getPrice() * $quantity,
            'user_id' => User::factory()->create()->getKey(),
        ]);

        $order->orderItems()->create([
            'quantity' => $quantity,
            'unit_price' => $product->getPrice(),
            'subtotal' => $product->getPrice() * $quantity,
            'product_id' => $product->getId(),
        ]);
    }
}

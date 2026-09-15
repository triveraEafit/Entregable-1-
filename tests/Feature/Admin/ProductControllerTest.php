<?php

namespace Tests\Feature\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setLocale('es');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_customer_is_forbidden_from_managing_products(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer)->get(route('admin.products.index'));

        $response->assertForbidden();
    }

    public function test_index_lists_products_with_their_brand_and_category(): void
    {
        $product = Product::factory()->create(['name' => 'Laptop ThinkPad X1']);

        $response = $this->actingAs($this->admin())->get(route('admin.products.index'));

        $response->assertSee('Laptop ThinkPad X1')
            ->assertSee($product->getBrand()->getName())
            ->assertSee($product->getCategory()->getName());
    }

    public function test_create_form_lists_brands_and_categories(): void
    {
        Brand::factory()->create(['name' => 'Lenovo']);
        Category::factory()->create(['name' => 'Laptops']);

        $response = $this->actingAs($this->admin())->get(route('admin.products.create'));

        $response->assertSee('Lenovo')->assertSee('Laptops');
    }

    public function test_store_creates_product_and_saves_uploaded_image(): void
    {
        Storage::fake('public');
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin())->post(route('admin.products.store'), [
            'name' => 'Portátil Zenbook 14',
            'description' => 'Ultraliviano con pantalla OLED',
            'price' => '3200000.50',
            'stock' => '8',
            'active' => '1',
            'brand_id' => $brand->getId(),
            'category_id' => $category->getId(),
            'image' => UploadedFile::fake()->image('zenbook.jpg'),
        ]);

        $response->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Producto creado correctamente.');

        $product = Product::sole();
        $this->assertSame('Portátil Zenbook 14', $product->getName());
        $this->assertSame(3200000.5, $product->getPrice());
        $this->assertSame(8, $product->getStock());
        $this->assertTrue($product->getActive());
        $this->assertSame($brand->getId(), $product->getBrandId());
        $this->assertSame($category->getId(), $product->getCategoryId());
        $this->assertStringStartsWith('products/', $product->getImage());
        Storage::disk('public')->assertExists($product->getImage());
    }

    public function test_store_saves_product_as_inactive_when_active_checkbox_is_unchecked(): void
    {
        $payload = Arr::except($this->productPayload(), 'active');

        $this->actingAs($this->admin())->post(route('admin.products.store'), $payload);

        $this->assertFalse(Product::sole()->getActive());
    }

    public function test_store_rejects_negative_price_and_stock(): void
    {
        $payload = $this->productPayload(['price' => '-1', 'stock' => '-3']);

        $response = $this->actingAs($this->admin())->post(route('admin.products.store'), $payload);

        $response->assertSessionHasErrors(['price', 'stock']);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_store_rejects_files_that_are_not_images(): void
    {
        Storage::fake('public');
        $payload = $this->productPayload([
            'image' => UploadedFile::fake()->create('manual.pdf', 100, 'application/pdf'),
        ]);

        $response = $this->actingAs($this->admin())->post(route('admin.products.store'), $payload);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('products', 0);
    }

    public function test_edit_form_is_filled_with_the_product_data(): void
    {
        $product = Product::factory()->create(['name' => 'Galaxy S24', 'stock' => 15]);

        $response = $this->actingAs($this->admin())->get(route('admin.products.edit', ['id' => $product->getId()]));

        $response->assertSee('value="Galaxy S24"', false)
            ->assertSee('value="15"', false);
    }

    public function test_edit_returns_404_for_unknown_product(): void
    {
        $response = $this->actingAs($this->admin())->get(route('admin.products.edit', ['id' => 999]));

        $response->assertNotFound();
    }

    public function test_update_changes_product_data_and_replaces_its_image(): void
    {
        Storage::fake('public');
        $previousImage = UploadedFile::fake()->image('old.jpg')->store('products', 'public');
        $product = Product::factory()->create(['image' => $previousImage]);
        $payload = $this->productPayload([
            'name' => 'Nombre editado',
            'stock' => '12',
            'image' => UploadedFile::fake()->image('new.jpg'),
        ]);

        $response = $this->actingAs($this->admin())->put(route('admin.products.update', ['id' => $product->getId()]), $payload);

        $response->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Producto actualizado correctamente.');

        $product->refresh();
        $this->assertSame('Nombre editado', $product->getName());
        $this->assertSame(12, $product->getStock());
        $this->assertNotSame($previousImage, $product->getImage());
        Storage::disk('public')->assertExists($product->getImage());
        Storage::disk('public')->assertMissing($previousImage);
    }

    public function test_update_keeps_current_image_when_no_new_file_is_uploaded(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('laptop.jpg')->store('products', 'public');
        $product = Product::factory()->create(['image' => $image]);

        $this->actingAs($this->admin())->put(route('admin.products.update', ['id' => $product->getId()]), $this->productPayload());

        $this->assertSame($image, $product->refresh()->getImage());
        Storage::disk('public')->assertExists($image);
    }

    public function test_update_deactivates_product_when_active_checkbox_is_unchecked(): void
    {
        $product = Product::factory()->create();
        $payload = Arr::except($this->productPayload(), 'active');

        $this->actingAs($this->admin())->put(route('admin.products.update', ['id' => $product->getId()]), $payload);

        $this->assertFalse($product->refresh()->getActive());
    }

    public function test_deactivate_marks_product_inactive_without_deleting_it(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin())->patch(route('admin.products.deactivate', ['id' => $product->getId()]));

        $response->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Producto desactivado.');

        $this->assertModelExists($product);
        $this->assertFalse($product->refresh()->getActive());
    }

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function productPayload(array $overrides = []): array
    {
        return [
            'name' => 'Teclado mecánico',
            'description' => 'Switches rojos',
            'price' => '250000',
            'stock' => '8',
            'active' => '1',
            'brand_id' => $overrides['brand_id'] ?? Brand::factory()->create()->getId(),
            'category_id' => $overrides['category_id'] ?? Category::factory()->create()->getId(),
            ...$overrides,
        ];
    }
}

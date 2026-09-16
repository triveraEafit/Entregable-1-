<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Tienda',
            'email' => 'admin@tienda.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $clientes = User::factory()->count(5)->create(['role' => 'cliente']);

        $categorias = collect([
            ['name' => 'Laptops', 'description' => 'Computadores portátiles'],
            ['name' => 'Celulares', 'description' => 'Smartphones y accesorios'],
            ['name' => 'Audio', 'description' => 'Audífonos y parlantes'],
            ['name' => 'Componentes', 'description' => 'Partes internas de PC'],
        ])->map(fn ($c) => Category::create($c));

        $marcas = collect([
            ['name' => 'Lenovo', 'country' => 'China', 'website' => 'https://lenovo.com'],
            ['name' => 'Samsung', 'country' => 'Corea del Sur', 'website' => 'https://samsung.com'],
            ['name' => 'Sony', 'country' => 'Japón', 'website' => 'https://sony.com'],
            ['name' => 'Logitech', 'country' => 'Suiza', 'website' => 'https://logitech.com'],
        ])->map(fn ($m) => Brand::create($m));

        $productos = collect([
            ['name' => 'Laptop ThinkPad X1', 'price' => 4500000, 'stock' => 10, 'category' => 'Laptops', 'brand' => 'Lenovo'],
            ['name' => 'Galaxy S24', 'price' => 3800000, 'stock' => 15, 'category' => 'Celulares', 'brand' => 'Samsung'],
            ['name' => 'Audífonos WH-1000XM5', 'price' => 1200000, 'stock' => 20, 'category' => 'Audio', 'brand' => 'Sony'],
            ['name' => 'Mouse MX Master 3', 'price' => 350000, 'stock' => 30, 'category' => 'Componentes', 'brand' => 'Logitech'],
        ])->map(function ($p) use ($categorias, $marcas) {
            return Product::create([
                'name' => $p['name'],
                'description' => "Descripción de {$p['name']}",
                'price' => $p['price'],
                'stock' => $p['stock'],
                'active' => true,
                'category_id' => $categorias->firstWhere('name', $p['category'])->id,
                'brand_id' => $marcas->firstWhere('name', $p['brand'])->id,
            ]);
        });

        foreach ($productos as $producto) {
            foreach ($clientes->random(2) as $cliente) {
                Review::create([
                    'rating' => rand(3, 5),
                    'comment' => 'Muy buen producto, cumple lo esperado.',
                    'created_at_review' => now(),
                    'user_id' => $cliente->id,
                    'product_id' => $producto->id,
                ]);
            }
        }

        $order = Order::create([
            'order_date' => now(),
            'status' => 'pagado',
            'total_amount' => 0,
            'user_id' => $clientes->first()->id,
        ]);

        $item = $order->orderItems()->create([
            'quantity' => 1,
            'unit_price' => $productos->first()->price,
            'subtotal' => 0,
            'product_id' => $productos->first()->id,
        ]);
        $item->calculateSubtotal();
        $order->calculateTotal();
    }
}

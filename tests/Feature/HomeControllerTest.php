<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setLocale('es');
    }

    public function test_home_page_welcomes_the_visitor_and_links_to_the_store_sections(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('Tienda de Tecnología')
            ->assertSee('Ver catálogo de productos')
            ->assertSee('Productos más vendidos')
            ->assertSee('Productos más comentados');
    }
}

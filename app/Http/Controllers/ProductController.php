<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $products
    ) {}

    public function index(): View
    {
        $data = [
            'products' => $this->products->paginateActive(),
        ];

        return view('products.index', $data);
    }

    /**
     * Funcionalidad interesante 1: búsqueda de productos por nombre.
     */
    public function search(Request $request): View
    {
        $term = (string) $request->query('q', '');

        $data = [
            'products' => $term !== ''
                ? $this->products->searchByName($term)
                : $this->products->paginateActive(),
            'term' => $term,
        ];

        return view('products.index', $data);
    }

    public function show(int $id): View
    {
        $data = [
            'product' => $this->products->findWithRelations($id),
        ];

        return view('products.show', $data);
    }

    /**
     * Funcionalidad interesante 2: top 4 productos más comentados.
     */
    public function topCommented(): View
    {
        $data = [
            'products' => $this->products->topCommented(4),
        ];

        return view('products.top-commented', $data);
    }
}

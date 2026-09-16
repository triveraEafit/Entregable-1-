<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
        private readonly CategoryRepositoryInterface $categories,
        private readonly BrandRepositoryInterface $brands,
    ) {}

    public function index(): View
    {
        $viewData = [
            'products' => $this->products->paginateActive(),
        ];

        return view('products.index')->with('viewData', $viewData);
    }

    /**
     * Funcionalidad interesante: búsqueda de productos por nombre.
     */
    public function search(Request $request): View
    {
        $term = (string) $request->query('q', '');

        $viewData = [
            'products' => $term !== ''
                ? $this->products->searchByName($term)
                : $this->products->paginateActive(),
            'term' => $term,
        ];

        return view('products.index')->with('viewData', $viewData);
    }

    /**
     * Funcionalidad interesante: filtro de productos por categoría y/o marca.
     */
    public function filter(Request $request): View
    {
        $categoryId = $request->query('category_id') ? (int) $request->query('category_id') : null;
        $brandId = $request->query('brand_id') ? (int) $request->query('brand_id') : null;

        $viewData = [
            'products' => $this->products->filterByCategoryAndBrand($categoryId, $brandId),
            'categories' => $this->categories->all(),
            'brands' => $this->brands->all(),
            'selectedCategoryId' => $categoryId,
            'selectedBrandId' => $brandId,
        ];

        return view('products.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $viewData = [
            'product' => $this->products->findWithRelations((int) $id),
        ];

        return view('products.show')->with('viewData', $viewData);
    }

    /**
     * Funcionalidad interesante: top 4 productos más comentados.
     */
    public function topCommented(): View
    {
        $viewData = [
            'products' => $this->products->topCommented(4),
        ];

        return view('products.top-commented')->with('viewData', $viewData);
    }
}

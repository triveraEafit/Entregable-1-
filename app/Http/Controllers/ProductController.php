<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $products
    ) {}

    public function index(): View
    {
        $viewData = [
            'products' => $this->products->paginateActive(),
        ];

        return view('products.index')->with('viewData', $viewData);
    }

    /**
     * Interesting feature: search products by name.
     */
    public function search(SearchProductRequest $request): View
    {
        $term = (string) $request->validated('q');

        $viewData = [
            'products' => $this->products->searchByName($term),
            'term' => $term,
        ];

        return view('products.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $viewData = [
            'product' => $this->products->findActiveWithRelations($id),
        ];

        return view('products.show')->with('viewData', $viewData);
    }

    /**
     * Interesting feature: top 4 most commented products.
     */
    public function topCommented(): View
    {
        $viewData = [
            'products' => $this->products->topCommented(4),
        ];

        return view('products.top-commented')->with('viewData', $viewData);
    }

    /**
     * Interesting feature: top 5 best-selling products.
     */
    public function topSelling(): View
    {
        $viewData = [
            'products' => $this->products->topSelling(5),
        ];

        return view('products.top-selling')->with('viewData', $viewData);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductRequest;
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

    /**
     * Interesting feature: filter products by category and/or brand.
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
